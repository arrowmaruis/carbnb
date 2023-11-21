<?php

namespace App\Filament\Resources\ConcessionnairesResource\Pages;

use App\Filament\Resources\ConcessionnairesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConcessionnaires extends ManageRecords
{
    protected static string $resource = ConcessionnairesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
