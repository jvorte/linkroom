<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Προσπάθησε να πάρεις locale από query (?lang=de ή ?lang=en)
        $locale = $request->get('lang');

        // Εναλλακτικά μπορείς να διαβάσεις από session/cookie
        if (!in_array($locale, ['en', 'de'])) {
            $locale = 'en'; // default
        }
           if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        App::setLocale($locale);

        return $next($request);
    }
}