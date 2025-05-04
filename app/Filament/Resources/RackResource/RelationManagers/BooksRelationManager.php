<?php

namespace App\Filament\Resources\RackResource\RelationManagers;

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
                Tables\Actions\Action::make('asociarLibro')
                    ->label('Asociar libro')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Forms\Components\Select::make('book_id')
                            ->label('Libro a asociar')
                            ->options(function ($livewire) {
                                $rack = $livewire->getOwnerRecord();
                                // Libros asociados a racks distintos al actual
                                return \App\Models\Book::where('rack_id', '!=', $rack->id)
                                    ->get()
                                    ->mapWithKeys(function ($book) {
                                        $rackName = $book->rack ? $book->rack->name : 'Sin rack';
                                        return [$book->id => $book->title . ' (' . $rackName . ')'];
                                    });
                            })
                            ->required(),
                    ])
                    ->action(function (array $data, $livewire) {
                        // Asocia el libro seleccionado al rack actual
                        $rack = $livewire->getOwnerRecord();
                        $book = \App\Models\Book::find($data['book_id']);
                        if ($book && $rack) {
                            $book->rack_id = $rack->id;
                            $book->save();
                            //$this->notify('success', 'Libro asociado correctamente');
                        } else {
                            //$this->notify('danger', 'No se pudo asociar el libro');
                        }
                    })
                    ->modalWidth('md')
                    ->modalHeading('Asociar libro')
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\Action::make('mover')
                    ->label('Mover libro')
                    ->icon('heroicon-o-arrow-right')
                    ->form([
                        Forms\Components\Select::make('nuevo_rack_id')
                            ->label('Mover a rack')
                            ->options(function ($livewire, $record) {
                                // Excluye el rack actual
                                $actualRackId = $record->rack_id;
                                return \App\Models\Rack::where('id', '!=', $actualRackId)->pluck('name', 'id');
                            })
                            ->required(),
                    ])
                    ->action(function (array $data, $livewire, $record) {
                        $nuevoRack = \App\Models\Rack::find($data['nuevo_rack_id']);
                        if ($nuevoRack) {
                            $record->rack_id = $nuevoRack->id;
                            $record->save();
                            //$this->notify('success', 'Libro movido correctamente');
                        } else {
                            //$this->notify('danger', 'No se pudo mover el libro');
                        }
                    })
                    ->modalWidth('sm')
                    ->modalHeading('Mover libro a otro rack')
                    ->color('warning'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('moverLibros')
                        ->label('Mover seleccionados a otro rack')
                        ->icon('heroicon-o-arrow-right')
                        ->form([
                            Forms\Components\Select::make('rack_destino')
                                ->label('Rack de destino')
                                ->options(fn ($livewire) => \App\Models\Rack::where('id', '!=', $livewire->getOwnerRecord()->id)->pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            $rackDestinoId = $data['rack_destino'] ?? null;
                            if ($rackDestinoId) {
                                foreach ($records as $book) {
                                    $book->rack_id = $rackDestinoId;
                                    $book->save();
                                }
                            }
                        })
                        ->modalWidth('md')
                        ->modalHeading('Mover seleccionados a otro rack')
                        ->color('warning'),
                ]),
            ]);
    }
}
