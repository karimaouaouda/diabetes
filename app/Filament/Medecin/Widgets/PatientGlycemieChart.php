<?php

namespace App\Filament\Medecin\Widgets;

use App\Models\Glycemie;
use Filament\Widgets\ChartWidget;

class PatientGlycemieChart extends ChartWidget
{
    public ?int $patientId = null;

    protected static ?string $heading = 'Évolution glycémique';

    protected function getData(): array
    {
        $records = Glycemie::where('patient_id', $this->patientId)
            ->orderBy('date_mesure')
            ->orderBy('heure_mesure')
            ->take(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Valeur (mmol/L)',
                    'data' => $records->pluck('valeur'),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#3b82f680',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $records->map(fn ($item) => $item->date_mesure->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
