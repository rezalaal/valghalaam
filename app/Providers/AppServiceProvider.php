<?php

namespace App\Providers;

use App\View\Components\Header;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        Blade::directive('farsi', fn($exp) => "<?php echo farsi($exp); ?>");

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // if (app()->environment('local')) {
        //     \Event::listen('Illuminate\Foundation\Http\Events\RequestHandled', function ($event) {
        //         $request = $event->request;
        //         $response = $event->response;
                
        //         logger('=== SESSION DEBUG ===');
        //         logger('URL: ' . $request->fullUrl());
        //         logger('Method: ' . $request->method());
        //         logger('Session ID: ' . session()->getId());
        //         logger('CSRF Token: ' . csrf_token());
        //         logger('Session Data: ' . json_encode(session()->all()));
        //         logger('Cookies: ' . json_encode($request->cookies->all()));
        //         logger('=== END DEBUG ===');
        //     });
        // }
    }
}
