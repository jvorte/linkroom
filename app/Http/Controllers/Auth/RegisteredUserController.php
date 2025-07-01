<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Category;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
   public function create(): View
{
    $categories = Category::all();
    return view('auth.register', compact('categories'));
}

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request)
{
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'bio' => 'nullable|string',
    'public_email' => 'nullable|email|max:255|unique:users,public_email',
    'phone' => 'nullable|string|max:50',
    'categories' => 'nullable|array',
    'categories.*' => 'exists:categories,id',
    'country' => 'required|string|max:255',  // προσθήκη country
]);

$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'bio' => $request->bio,
    'public_email' => $request->public_email,
    'phone' => $request->phone,
    'country' => $request->country,  // προσθήκη country
]);


// Αν δόθηκαν κατηγορίες, κάνε sync
if ($request->has('categories')) {
    $user->categories()->sync($request->categories);
}


    // Αν έχεις κατηγορίες, μετά μπορείς να κάνεις sync

    Auth::login($user);
      return redirect()->route('profile.edit')->with('success', 'Ο λογαριασμός δημιουργήθηκε! Συμπλήρωσε το προφίλ σου για να εμφανίζεσαι στους επισκέπτες.');



        // return redirect(route('dashboard', absolute: false));
    }
}
