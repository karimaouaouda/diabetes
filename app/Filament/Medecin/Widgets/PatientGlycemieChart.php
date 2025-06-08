<?php

namespace App\Filament\Medecin\Widgets;

use App\Models\Glycemies;
use Filament\Widgets\ChartWidget;

class PatientGlycemieChart extends ChartWidget
{
    public ?int $patientId = null;

    protected static ?string $heading = 'Évolution glycémique';

    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $records = Glycemies::where('patient_id', 2)
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
