<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowResource\Pages;
use App\Filament\Resources\BorrowResource\RelationManagers;
use App\Models\Borrow;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowResource extends Resource
{
    protected static ?string $model = Borrow::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Member')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->required(),
                DatePicker::make('borrowed_at')
                    ->required(),
                Repeater::make('borrowBooks')
                    ->relationship()
                    ->schema([
                        Select::make('book_id')
                            ->relationship('book', 'title')
                            ->required()
                    ])->columnSpanFull(),

                DatePicker::make('due_date')
                    ->required(),
                DatePicker::make('returned_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('borrow_books_count')
                    ->label('Total Borrowed Books')
                    ->counts('borrowBooks'),
                TextColumn::make('borrowed_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('returned_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(function ($record) {
                        $now = now();
                        if ($record->returned_at) {
                            return 'Devuelto';
                        }
                        
                        $due = $record->due_date ? \Carbon\Carbon::parse($record->due_date) : null;
                        if ($due) {
                            if ($now->gt($due)) {
                                return 'Vencido';
                            } elseif ($now->diffInDays($due, false) <= 3) {
                                return 'Por vencer';
                            } else {
                                return 'En curso';
                            }
                        }
                        return '-';
                    })
                    ->badge()
                    ->color(function ($state) {
                        if ($state === 'Devuelto') return 'gray';
                        if ($state === 'Vencido') return 'danger';
                        if ($state === 'Por vencer') return 'warning';
                        if ($state === 'En curso') return 'success';
                        return 'gray';
                    }),
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
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Usuario')
                    ->relationship('user', 'name')
                    ->searchable(),
                Tables\Filters\Filter::make('borrowed_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Desde'),
                        Forms\Components\DatePicker::make('to')->label('Hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('borrowed_at', '>=', $data['from']);
                        }
                        if ($data['to']) {
                            $query->whereDate('borrowed_at', '<=', $data['to']);
                        }
                    }),
                Tables\Filters\Filter::make('book_title')
                    ->label('Título de libro')
                    ->form([
                        Forms\Components\TextInput::make('title')->label('Título contiene...'),
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['title']) {
                            $query->whereHas('borrowBooks.book', function ($q) use ($data) {
                                $q->where('title', 'like', '%'.$data['title'].'%');
                            });
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrows::route('/'),
            'create' => Pages\CreateBorrow::route('/create'),
            'edit' => Pages\EditBorrow::route('/{record}/edit'),
        ];
    }
}
