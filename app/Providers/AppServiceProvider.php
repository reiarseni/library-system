<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Borrow;
use App\Models\BorrowBook;
use App\Observers\BorrowObserver;
use App\Observers\BorrowBookObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Borrow::observe(BorrowObserver::class);
        BorrowBook::observe(BorrowBookObserver::class);
    }
}
