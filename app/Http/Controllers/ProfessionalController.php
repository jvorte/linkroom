<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{public function index(Request $request)
{
    $categories = Category::all();
    $mainCategories = $categories->whereNull('parent_id');

    $query = User::with('categories');

    if ($request->has('categories')) {
        $selectedSlugs = $request->input('categories', []);
        $categoryIds = $categories->whereIn('slug', $selectedSlugs)->pluck('id')->toArray();

        if (!empty($categoryIds)) {
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }
    }

    if ($request->filled('country')) {
        $query->where('country', $request->country);
    }

    if ($request->boolean('remote_only')) {
        $query->where('remote', true);
    }

    if ($request->boolean('verified_only')) {
        $query->where('is_verified', true);
    }

    // Φίλτρο favorites μόνο αν ζητηθεί
    if ($request->boolean('favorites_only')) {
        $user = auth()->user();
        if ($user) {
            $favoriteIds = $user->favoriteProfessionals()->pluck('professional_id')->toArray();
            $query->whereIn('id', $favoriteIds);
        } else {
            $query->whereRaw('0=1');
        }
    }

    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('bio', 'like', '%' . $searchTerm . '%')
              ->orWhere('public_email', 'like', '%' . $searchTerm . '%');
        });
    }

    $professionals = $query->paginate(12);

    return view('professionals.index', [
        'professionals' => $professionals,
        'allCategories' => $categories,
        'mainCategories' => $mainCategories,
    ]);
}

 public function getSubcategories($parentId)
{
    $subcategories = Category::where('parent_id', $parentId)->get();
    return response()->json($subcategories);
}

}
