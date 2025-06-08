<?php

namespace App\Filament\Medecin\Widgets;

use App\Models\DoseInsuline;
use Filament\Widgets\ChartWidget;

class PatientInsulinChart extends ChartWidget
{
    public ?int $patientId = null;

    protected static ?string $heading = "Historique des doses d'insuline";

    protected function getData(): array
    {
        $records = DoseInsuline::where('patient_id', $this->patientId)
            ->orderBy('date_heure')
            ->take(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Dose (unités)',
                    'data' => $records->pluck('dose'),
                    'borderColor' => '#10b981',
                    'backgroundColor' => '#6ee7b7',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $records->map(fn ($item) => $item->date_heure->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
