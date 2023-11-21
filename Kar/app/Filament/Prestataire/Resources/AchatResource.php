<?php

namespace App\Filament\Prestataire\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Achat;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Reservations;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Prestataire\Resources\AchatResource\Pages;
use App\Filament\Prestataire\Resources\AchatResource\RelationManagers;

class AchatResource extends Resource
{
    protected static ?string $model = Reservations::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Gestion des commandes';
    public static ?string $navigationLabel = 'Achats';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('pickup_at', null)->count();
    }

    public function context($request, $resource)
    {
        return $resource->model()::where('user_id', auth()->id())
            ->join('cars', 'reservations.car_id', '=', 'cars.id')
            ->select('reservations.*', 'cars.model as car_model', 'cars.year as car_year');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            // Définissez votre schéma ici
            Section::make('Informations du Clients')
                ->schema([
                    TextEntry::make('users.id'),
                    TextEntry::make('users.name'),
                    TextEntry::make('users.email')
                ])->columns(3),
            Section::make('Vehicules concerné')
                ->schema([
                    ImageEntry::make('cars.photos')
                        ->height(40)
                        ->circular()
                        ->stacked()
                        ->limit(3)
                        ->limitedRemainingText(),
                    TextEntry::make('cars.models.model')
                        ->label("Model"),
                    TextEntry::make('cars.models.year')
                        ->label("Année"),
                    TextEntry::make('cars.models.fabricant')
                        ->label("fabricant"),
                    TextEntry::make('cars.user.id')
                        ->label('Identifiant'),
                    TextEntry::make('cars.user.name')
                        ->label('Concessionnaire'),
                    TextEntry::make('cars.user.email')
                        ->label('Email'),

                ])->columns(4),
            Section::make('Detail de la comande')
                ->schema([
                    TextEntry::make('id')
                        ->label('Id Reser..'),
                    TextEntry::make('cost')
                        ->label('Montant en Fcfa')
                        ->numeric(
                            decimalPlaces: 0,
                            decimalSeparator: ',',
                            thousandsSeparator: '.',
                        ),
                    TextEntry::make('status'),
                    TextEntry::make('created_at')
                        ->label('Date de la commande'),

                ])->columns(4),

        ]);
    }

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
                return Reservations::where('pickup_at', null)
                    ->join('cars', 'reservations.cars_id', '=', 'cars.id')
                    ->join('models', 'models.id', '=', 'cars.models_id')
                    ->where('cars.user_id', auth()->id())
                    ->select('reservations.*', 'cars.*');
            })

            ->columns([
                TextColumn::make('id')
                    ->label("Id Res..")
                    ->sortable(),
                TextColumn::make('users.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cars.user.name')
                    ->label('Concessionnaire')
                    ->sortable(),
                TextColumn::make('cars.id')
                    ->label('ID Veh..')
                    ->sortable(),
                ImageColumn::make('cars.photos')
                    ->label('Veh. img')
                    ->limit(1)
                    ->circular(),

                TextColumn::make('cars.models.model')
                    ->label('Vehicule')
                    ->limit(12)
                    ->sortable(),
                TextColumn::make('cost')
                    ->label('Prix en Fcfa')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: ',',
                        thousandsSeparator: '.',
                    )
                    ->sortable(),



                TextColumn::make('status'),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->limit(10)
                    ->sortable(),
            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

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
            'index' => Pages\ManageAchats::route('/'),
        ];
    }
}
