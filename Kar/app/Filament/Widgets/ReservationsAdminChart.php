<?php

namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use App\Models\Reservations;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class ReservationsAdminChart extends ChartWidget
{
    protected static ?string $heading = 'Graphique des reservations';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $data = Trend::model(Reservations::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'reservations effectué',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        ];
    }



    protected function getType(): string
    {
        return 'bar';
    }
}
