<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Select::make('authors')
                            ->multiple()
                            ->relationship(titleAttribute: 'name', name: 'authors')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nombre del autor'),
                            ]),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Select::make('genres')
                            ->label('Género')
                            ->multiple()
                            ->relationship(titleAttribute: 'name', name: 'genres')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nombre del género'),
                            ]),
                        Forms\Components\TextInput::make('isbn')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('copies')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->afterStateUpdated(function ($state, $set) {
                                // Al actualizar las copias totales, actualizar también las disponibles
                                $set('available_copies', $state);
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('available_copies')
                            ->label('Copias disponibles')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn($record) => $record?->available_copies)
                            ->formatStateUsing(function ($state, $get, $set, $record) {
                                // Si estamos editando, usar el accesor dinámico
                                if ($record) {
                                    return $record->available_copies;
                                }
                                // En creación, calcular en base a 'copies' y préstamos activos (0)
                                $total = $get('copies') ?? 0;
                                return $total;
                            })
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, $get, $livewire) {
                                // Recalcular cuando cambie 'copies'
                                $copies = $get('copies') ?? 0;
                                $set('available_copies', $copies);
                            }),
                    ]),

                Forms\Components\Textarea::make('synopsis')
                    ->label('Synopsis')
                    ->rows(4)
                    ->autosize()
                    ->placeholder('Enter a short synopsis...')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('cover_image')
                    ->label('Imagen de portada')
                    ->image()
                    ->directory('covers')
                    ->previewable(true)
                    ->downloadable()
                    ->deletable(true)
                    ->openable()
                    ->removeUploadedFileButtonPosition('right')
                    ->columnSpanFull(),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Select::make('rack_id')
                            ->label('Rack')
                            ->relationship(titleAttribute: 'name', name: 'rack'),
                        Forms\Components\TextInput::make('shelf_number')
                            ->label('Nivel')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->placeholder('Ej: 5'),
                        Forms\Components\TextInput::make('call_number')
                            ->label('Código de clasificación')
                            ->maxLength(50)
                            ->placeholder('Ej: QA76.73.P224'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('authors.name')
                    ->label('Authors')
                    ->limit(30)
                    ->searchable(),

                \Filament\Tables\Columns\ImageColumn::make('cover_image')
    ->label('Cover')
    ->square()
    ->size(48)
    ->defaultImageUrl(fn() => asset('images/default_cover.png'))
    ->url(fn ($record) => $record->cover_image ? asset('storage/covers/' . basename($record->cover_image)) : null),

                TextColumn::make('genres.name')
                    ->label('Género')
                    ->limit(30),

                BadgeColumn::make('available_copies')
                    ->label('Copias Disponibles')
                    ->sortable()
                    ->color(fn (Book $record): string => match (true) {
                        $record->available_copies <= 0 => 'danger',
                        $record->available_copies == 1 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn (int $state, Book $record): string => "{$state} de {$record->copies}"),

                // Campos opcionales en el desplegable Columns
                TextColumn::make('copies')
                    ->numeric()
                    ->sortable()
                    ->label('Copias Totales')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('isbn')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('synopsis')
                    ->label('Synopsis')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\AuthorsRelationManager::class,
            RelationManagers\GenresRelationManager::class,
            RelationManagers\BorrowsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
