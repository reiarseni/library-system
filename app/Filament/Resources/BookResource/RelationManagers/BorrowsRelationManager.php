<?php

namespace App\Filament\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Borrow;
use App\Models\BorrowBook;

class BorrowsRelationManager extends RelationManager
{
    protected static string $relationship = 'borrows';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $title = 'Préstamos';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrowed_at')
                    ->label('Fecha de préstamo')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Fecha de vencimiento')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('returned_at')
                    ->label('Fecha de devolución')
                    ->date('d/m/Y')
                    ->placeholder('Pendiente')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(function (Borrow $record): string {
                        if ($record->returned_at) {
                            return 'Devuelto';
                        }
                        
                        if ($record->due_date < now()) {
                            return 'Vencido';
                        }
                        
                        return 'Prestado';
                    })
                    ->colors([
                        'success' => 'Devuelto',
                        'warning' => 'Prestado',
                        'danger' => 'Vencido',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'prestado' => 'Prestado',
                        'devuelto' => 'Devuelto',
                        'vencido' => 'Vencido',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['value'] === 'prestado',
                                fn (Builder $query): Builder => $query->whereNull('returned_at')->where('due_date', '>=', now()),
                            )
                            ->when(
                                $data['value'] === 'devuelto',
                                fn (Builder $query): Builder => $query->whereNotNull('returned_at'),
                            )
                            ->when(
                                $data['value'] === 'vencido',
                                fn (Builder $query): Builder => $query->whereNull('returned_at')->where('due_date', '<', now()),
                            );
                    }),
            ])
            ->headerActions([
                // No permitimos crear préstamos directamente desde aquí
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No permitimos acciones masivas
            ]);
    }
}
