<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessionalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;


// Δημόσιες Σελίδες
Route::get('/', fn() => view('welcome'));
Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');
Route::get('/u/{slug}', [ProfileController::class, 'show'])->name('profile.show'); // μόνο ένα show route

// Αυθεντικοποιημένοι Χρήστες
Route::middleware(['auth'])->group(function () {
    
    // Dashboard για διαχείριση links
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/links', [DashboardController::class, 'store'])->name('dashboard.links.store');
        Route::put('/links/{link}', [DashboardController::class, 'update'])->name('dashboard.links.update');
        Route::delete('/links/{link}', [DashboardController::class, 'destroy'])->name('dashboard.links.destroy');
        Route::post('/links/reorder', [DashboardController::class, 'reorder'])->name('dashboard.links.reorder');
    });

    // Προφίλ χρήστη (προβολή/επεξεργασία)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update'); // Ενοποιημένο update
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/locale', function (Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'de'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

require __DIR__.'/auth.php';
