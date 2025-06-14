<?php


namespace App\Filament\Patient\Widgets;

use App\Models\Glycemies;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

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
        $data = Trend::model(Glycemies::class)
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
                    'data' => [
                        ...$data->map(fn ($value) => $value->aggregate),
                    ],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#3b82f680',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => [],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
