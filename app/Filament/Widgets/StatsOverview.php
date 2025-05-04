<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Genre;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static int $columns = 4;

    protected function getStats(): array
    {
        $now = now();
        $totalBorrows = Borrow::count();
        $enCurso = Borrow::whereNull('returned_at')
            ->whereDate('due_date', '>', $now->copy()->addDays(3))
            ->count();
        $porVencer = Borrow::whereNull('returned_at')
            ->whereDate('due_date', '>', $now)
            ->whereDate('due_date', '<=', $now->copy()->addDays(3))
            ->count();
        $vencidos = Borrow::whereNull('returned_at')
            ->whereDate('due_date', '<', $now)
            ->count();

        return [
            Stat::make('Total Books', Book::count()),
            Stat::make('Total Authors', Author::count()),
            Stat::make('Total Genres', Genre::count()),
            Stat::make('Total Members', User::count()),

            Stat::make('Total Préstamos', $totalBorrows),
            Stat::make('En curso', $enCurso),
            Stat::make('Por vencer', $porVencer),
            Stat::make('Vencidos', $vencidos),
        ];
    }
}
