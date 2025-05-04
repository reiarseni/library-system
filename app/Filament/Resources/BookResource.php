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
                TextInput::make('title')
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

                Select::make('genres')
                    ->multiple()
                    ->relationship(titleAttribute: 'name', name: 'genres')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre del género'),
                    ]),
                
                Select::make('rack_id')
                    ->relationship(titleAttribute: 'name', name: 'rack'),

                TextInput::make('copies')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->afterStateUpdated(function ($state, $set) {
                        // Al actualizar las copias totales, actualizar también las disponibles
                        $set('available_copies', $state);
                    })
                    ->reactive(),
                    
                TextInput::make('available_copies')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->lte('copies')
                    ->reactive(),
                Forms\Components\TextInput::make('isbn')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('authors.name')
                    ->searchable(),

                TextColumn::make('genres.name'),

                TextColumn::make('copies')
                    ->numeric()
                    ->sortable()
                    ->label('Copias Totales'),
                    
                BadgeColumn::make('available_copies')
                    ->label('Copias Disponibles')
                    ->sortable()
                    ->color(fn (Book $record): string => match (true) {
                        $record->available_copies <= 0 => 'danger',
                        $record->available_copies == 1 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn (int $state, Book $record): string => 
                        "{$state} de {$record->copies}"),

                TextColumn::make('isbn')
                    ->searchable(),

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
