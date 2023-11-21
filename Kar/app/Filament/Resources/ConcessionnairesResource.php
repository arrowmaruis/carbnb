<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Password;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use App\Filament\Resources\ConcessionnairesResource\Pages;
use App\Filament\Resources\ConcessionnairesResource\RelationManagers;

class ConcessionnairesResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Panneau dadministration';

    public static ?string $navigationLabel = 'Concessionnaires';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('role', 'Concessionnaire')->count();
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
                        'Concessionnaire' => 'Concessionnaire',
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
                return User::where('role', 'Concessionnaire');
            })
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email'),
                TextColumn::make('role')->sortable(),
               
                TextColumn::make('created_at')
                    ->label('Membre depuis')
                    ->since(),
                    ToggleIconColumn::make('is_locked')
                    ->label("Bloqué")
                    ->onIcon('heroicon-s-lock-closed')
                    ->offIcon('heroicon-o-lock-open'),
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
            'index' => Pages\ManageConcessionnaires::route('/'),
        ];
    }
}
