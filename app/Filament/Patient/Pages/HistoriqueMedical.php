<?php

namespace App\Filament\Patient\Pages;

use App\Models\Glycemie;
use App\Models\DoseInsuline;
use Filament\Pages\Page;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class HistoriqueMedical extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static string $view = 'filament.patient.pages.historique-medical';
    protected static ?string $navigationLabel = 'Historique Médical';
    protected static ?string $title = 'Mon Historique de Santé';
    protected static ?string $slug = 'historique-medical';

    public $selectedPeriod = '30'; // 30 jours par défaut
// app/Filament/Patient/Pages/HistoriqueMedical.php

  //protected static string $view = 'filament.patient.pages.historique-medical';

// Ajoutez cette propriété
public $glycemies;

// Ajoutez cette méthode
public function mount()
{
    $this->glycemies = Glycemie::where('patient_id', auth()->id())
        ->latest('date_mesure')
        ->take(5)
        ->get();
}
    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
           // HistoriqueGlycemieWidget::class,
           // HistoriqueInsulineWidget::class,
        ];
    }

    public function getStats(): array
    {
        return [
            Stat::make('Moyenne Glycémie', $this->getMoyenneGlycemie().' mmol/L')
                ->description('sur '.$this->selectedPeriod.' jours'),
            Stat::make('Doses Insuline', $this->getTotalInsuline().' unités'),
            Stat::make('Consultations', $this->getNbConsultations()),
        ];
    }

    protected function getMoyenneGlycemie(): string
    {
        return number_format(
            Glycemie::where('patient_id', Auth::id())
                ->where('date_mesure', '>=', now()->subDays($this->selectedPeriod))
                ->avg('valeur') ?? 0,
            1
        );
    }

    protected function getTotalInsuline(): int
    {
        return DoseInsuline::where('patient_id', Auth::id())
            ->where('date_heure', '>=', now()->subDays($this->selectedPeriod))
            ->sum('dose') ?? 0;
    }

    protected function getNbConsultations(): string
    {
        $count = Consultation::where('patient_id', Auth::id())
            ->where('date', '>=', now()->subDays($this->selectedPeriod))
            ->count();

        return $count.' consultation'.($count > 1 ? 's' : '');
    }
    public function loadGlycemies()
{
    $this->readyToLoad = true;
}
}
