<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Η σελίδα όπου θα ανακατευθύνεται ο χρήστης μετά το login.
     */
    public const HOME = '/home';

    /**
     * Ορίζεις τις διαδρομές (routes) της εφαρμογής.
     */
    public function boot(): void
    {
        // Κλήση του parent boot
        parent::boot();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
