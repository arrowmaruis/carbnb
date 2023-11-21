<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdministrateursResource\Pages;
use App\Filament\Resources\AdministrateursResource\RelationManagers;

class AdministrateursResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Panneau dadministration';
    public static ?string $navigationLabel = 'Admin Et Gestionnaire';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereIn('role', ['is_admin', 'is_gestionnaire'])->count();
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->minLength(2)
                ->maxLength(50)
                ->label('Noms'),
            TextInput::make('email')
                ->email()
                ->unique()
                ->maxLength(100)
                ->required(),

            Select::make('role')
                ->required()
                ->options([
                    'is_admin' => 'is_admin',
                    'is_gestionnaire' => 'is_gestionnaire',
                    // Ajoutez d'autres options de rôle au besoin
                ]),

            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->required(fn (string $operation): bool => $operation === 'create'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(function () {
            return User::whereIn('role', ['is_admin', 'is_gestionnaire']);
        })
        
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email'),
                TextColumn::make('role')->sortable(),
                TextColumn::make('created_at')
                    ->label('Ajouter depuis')
                    ->since()
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
            'index' => Pages\ManageAdministrateurs::route('/'),
        ];
    }
}
