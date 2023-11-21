<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Models;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ModelsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ModelsResource\RelationManagers;

class ModelsResource extends Resource
{
    protected static ?string $model = Models::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-rays';
    public static ?string $navigationLabel = 'Models de vehicules';
    
    protected static ?string $navigationGroup = 'Gestion des Ressources';


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
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('fabricant')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('model')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('categorie')
                    ->sortable(),
                // TextColumn::make('sieges')
                //     ->sortable(),
                // TextColumn::make('portieres')
                //     ->sortable(),
                TextColumn::make('transmission')
                    ->limit(15),
                // TextColumn::make('Performances'),
                TextColumn::make('carburant')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageModels::route('/'),
        ];
    }
}
