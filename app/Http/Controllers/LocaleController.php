<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');

        // Διάλεξε μόνο τις υποστηριζόμενες γλώσσες
        $allowedLocales = ['en', 'de'];

        if (in_array($locale, $allowedLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        // Επιστροφή στην προηγούμενη σελίδα
        return redirect()->back();
    }
}
