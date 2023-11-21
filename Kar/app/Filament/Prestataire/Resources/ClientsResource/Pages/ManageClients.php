<?php

namespace App\Filament\Prestataire\Resources\ClientsResource\Pages;

use App\Filament\Prestataire\Resources\ClientsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClients extends ManageRecords
{
    protected static string $resource = ClientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
