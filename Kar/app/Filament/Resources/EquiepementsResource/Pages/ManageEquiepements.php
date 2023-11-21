<?php

namespace App\Filament\Resources\EquiepementsResource\Pages;

use App\Filament\Resources\EquiepementsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEquiepements extends ManageRecords
{
    protected static string $resource = EquiepementsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
