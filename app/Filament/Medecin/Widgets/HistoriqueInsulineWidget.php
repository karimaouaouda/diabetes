<?php

namespace App\Filament\Patient\Widgets;

use App\Models\DoseInsuline;
use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class HistoriqueInsulineWidget extends BarChartWidget
{
    protected static ?string $heading = 'Doses d\'Insuline';
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $data = Trend::model(DoseInsuline::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->sum('dose');

        return [
            'datasets' => [
                [
                    'label' => 'Unités d\'insuline',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#10b981',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
