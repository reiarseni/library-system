<?php

namespace App\Filament\Resources\GenreResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('associateBooks')
                    ->label('Asociar libro')
                    ->form([
                        Forms\Components\Select::make('books')
                            ->multiple()
                            ->label('Selecciona libros a asociar')
                            ->options(fn () => \App\Models\Book::pluck('title', 'id')),
                    ])
                    ->action(function (array $data, $livewire) {
                        /** @var \App\Models\Genre $genre */
                        $genre = $livewire->getOwnerRecord();
                        $books = $data['books'] ?? [];
                        if (!empty($books)) {
                            $genre->books()->syncWithoutDetaching($books);
                        }
                    })
                    ->modalWidth('lg'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make()
                    ->label('Desasociar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Desasociar'),
                ]),
            ]);
    }
}
