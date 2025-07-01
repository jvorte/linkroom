<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FavoriteController extends Controller
{
    public function toggle(Request $request, User $professional)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($user->id === $professional->id) {
            return response()->json(['message' => 'You cannot favorite yourself.'], 400);
        }

        // Ελέγχουμε αν ήδη υπάρχει το favorite
        $alreadyFavorited = $user->favoriteProfessionals()->where('professional_id', $professional->id)->exists();

        if ($alreadyFavorited) {
            $user->favoriteProfessionals()->detach($professional->id);
            $status = 'removed';
        } else {
            $user->favoriteProfessionals()->attach($professional->id);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'favorites_count' => $professional->favoritedByUsers()->count(),
        ]);
    }
}
