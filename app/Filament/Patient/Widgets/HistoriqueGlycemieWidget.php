<?php

namespace App\Filament\Patient\Widgets;

use App\Models\Glycemie;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class HistoriqueGlycemieWidget extends ChartWidget
{
    protected static ?string $heading = 'Historique des Glycémies';
    protected static ?string $pollingInterval = null;

    public function getDescription(): string
    {
        return 'Évolution sur les 30 derniers jours';
    }

    protected function getData(): array
    {
        $data = Trend::model(Glycemie::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->average('valeur');

        return [
            'datasets' => [
                [
                    'label' => 'Moyenne glycémique (mmol/L)',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#3b82f680',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
