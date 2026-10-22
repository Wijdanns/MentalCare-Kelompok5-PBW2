<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Psikolog;
use Illuminate\Support\Facades\View;

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
        View::composer('pasien.dashboard', function ($view) {
        $view->with(
            'psikologs',
            Psikolog::query()
                ->withCount(['jadwalTersedia as jadwal_tersedia_count'])
                ->take(3)
                ->get()
        );
    });
    }
}
