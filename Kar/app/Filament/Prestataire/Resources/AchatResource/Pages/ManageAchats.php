<?php

namespace App\Filament\Prestataire\Resources\AchatResource\Pages;

use Filament\Actions;
use App\Models\Reservations;
use Filament\Forms\Components\Builder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Prestataire\Resources\AchatResource;

class ManageAchats extends ManageRecords
{
    protected static string $resource = AchatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Demain' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('checkout_at', '>=', now()->subDay());
                })
                ->badge(Reservations::query()->where('checkout_at', '>=', now()->subDay())->count()),
            'Cette semaine' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('checkout_at', '>=', now()->subWeek());
                })
                ->badge(Reservations::query()->where('checkout_at', '>=', now()->subWeek())->count()),

            'Ce mois' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('checkout_at', '>=', now()->subMonth());
                })
                ->badge(Reservations::query()->where('checkout_at', '>=', now()->subMonth())->count()),
           
        ];
    }
}
