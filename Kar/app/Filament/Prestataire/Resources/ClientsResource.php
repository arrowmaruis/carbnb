<?php

namespace App\Filament\Prestataire\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Reservations;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Prestataire\Resources\ClientsResource\Pages;
use App\Filament\Prestataire\Resources\ClientsResource\RelationManagers;

class ClientsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Gestion des Clients';
    public static ?string $navigationLabel = 'Mes Clients';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Reservations::join('cars', 'reservations.cars_id', '=', 'cars.id')
                    ->join('models', 'models.id', '=', 'cars.models_id')
                    ->join('users', 'users.id', '=', 'reservations.user_id')
                    ->where('cars.user_id', auth()->id())
                    ->select('cars.*','reservations.*', 'users.*');
            })
            ->columns([
                TextColumn::make('reservations.user.name'),
                TextColumn::make('cars.user.name'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClients::route('/'),
        ];
    }
}
