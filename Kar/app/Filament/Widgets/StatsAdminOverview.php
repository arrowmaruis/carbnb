<?php

namespace App\Filament\Widgets;

use App\Models\Cars;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAdminOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '3s';
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Nombre d\'utilisateurs', User::query()->where('role','user')->count())
                ->description('Tous les utilisateur isncrit sur le site ')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Nombre de voitures', Cars::query()->count())
                ->description('Toutes les voitires disponible sur le site ')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Nombre de concessionaire', User::query()->where('role','Concessionnaire')->count())
                ->description('Tous nos partenaire concessionnaires')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
