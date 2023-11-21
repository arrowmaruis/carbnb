<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Cars;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Equipements;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Cache\RateLimiting\Limit;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CarsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use App\Filament\Resources\CarsResource\RelationManagers;

class CarsResource extends Resource
{
    protected static ?string $model = Cars::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Gestion des Ressources';
    public static ?string $navigationLabel = 'Liste des vehicules';

    public static function form(Form $form): Form
    {
        $user_id = Auth::id();

        // Récupérer la liste d'options pour la relation "type_politique" en excluant les politiques de l'utilisateur connecté
        $equipements = Equipements::all();

        // Créer un tableau d'options à partir de la liste d'équipements
        $equipementOptions = $equipements->pluck('name', 'name');

        return $form->schema([
            Hidden::make('user_id') // Champ user_id masqué
                ->default($user_id)
                ->required(),
            Select::make('models_id')
                ->relationship('models', 'model')
                ->searchable()
                ->required(),
            Select::make('equipements')
                ->multiple()
                ->searchable()
                ->options($equipementOptions) // Utiliser les options d'équipements
                ->required(),
            Select::make('etat')
                ->options(['Occasionnel' => 'Occasionnel', 'Neuf' => 'Neuf'])
                ->required(),
            TextInput::make('kilometrage')
                ->required(),
            Select::make('mode')
                ->options(['En vente' => 'En vente', 'En location' => 'En location'])
                ->required(),
            TextInput::make('prix')
                ->required(),

            Hidden::make('status')
                ->default('Disponible')
                ->required(),
            Textarea::make('description')
                ->minLength(30)
                ->maxLength(500)
                ->columnSpanFull()
                ->required(),
            FileUpload::make('photos')
                ->label('Télécharger des photos')
                ->multiple()
                ->appendFiles()
                ->moveFiles()
                ->image()
                ->required(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('photos')
                    ->limit(1)
                    ->circular(),

                TextColumn::make('models.model')
                    ->sortable()
                    ->Limit(15)
                    ->searchable(),
                TextColumn::make('models.categorie')
                    ->label('Categorie')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('models.fabricant')
                    ->label('Fabricant')
                    ->sortable()
                    ->Limit(15)
                    ->searchable(),
                TextColumn::make('mode')
                    ->sortable(),
                TextColumn::make('etat')
                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('models.portieres')
                    ->label('portieres')

                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('models.sieges')
                    ->label('sieges')

                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('models.transmission')
                    ->label('transmission')

                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('models.Performances')
                    ->label('Performances')

                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('models.carburant')
                    ->label('carburant')

                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('user.name')
                    ->label('Entreprise')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('prix')
                    ->label('Prix en FCFA')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: ',',
                        thousandsSeparator: '.',
                    )
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                ToggleIconColumn::make('is_locked')
                ->label("Bloqué")
                ->onIcon('heroicon-s-lock-closed')
                ->offIcon('heroicon-o-lock-open'),

                TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make("model")
                    ->relationship('models', 'model')
                    ->searchable()
                    ->preload(),
                SelectFilter::make("categorie")
                    ->relationship('models', 'categorie')
                    ->searchable()
                    ->preload(),

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
            'index' => Pages\ManageCars::route('/'),
        ];
    }
}
