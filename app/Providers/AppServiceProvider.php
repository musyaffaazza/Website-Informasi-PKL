<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');

        if ($currentMonth >= 7) {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
            $semester = 'Semester Ganjil';
        } else {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
            $semester = 'Semester Genap';
        }

        View::share('tahunAjaranAktif', "{$startYear}/{$endYear}");
        View::share('semesterAktif', $semester);
    }
}
