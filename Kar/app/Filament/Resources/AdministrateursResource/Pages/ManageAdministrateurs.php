<?php

namespace App\Filament\Resources\AdministrateursResource\Pages;

use App\Filament\Resources\AdministrateursResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAdministrateurs extends ManageRecords
{
    protected static string $resource = AdministrateursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
