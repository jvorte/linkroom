<?php

use App\Http\Controllers\{ProfileController, DashboardController, ProfessionalController, NewsletterController, LocaleController, ContactFormController};
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Δημόσιες Σελίδες
Route::get('/', fn() => view('welcome'));
Route::get('/home', [DashboardController::class, 'home'])->name('home');
Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');
Route::get('/u/{slug}', [ProfileController::class, 'show'])->name('profile.show');

// Contact
Route::get('/contact', [ContactFormController::class, 'show'])->name('contact');
Route::post('/contact', [ContactFormController::class, 'submit'])->name('contact.submit');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Locale Switcher
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'de'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/links', [DashboardController::class, 'store'])->name('dashboard.links.store');
        Route::put('/links/{link}', [DashboardController::class, 'update'])->name('dashboard.links.update');
        Route::delete('/links/{link}', [DashboardController::class, 'destroy'])->name('dashboard.links.destroy');
        Route::post('/links/reorder', [DashboardController::class, 'reorder'])->name('dashboard.links.reorder');
    });

    // Προφίλ
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin (προσωρινός έλεγχος με role στον controller)
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.index');
});

require __DIR__ . '/auth.php';
