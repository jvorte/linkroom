<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('categories')->whereHas('links');

        if ($request->has('categories')) {
            $selectedSlugs = $request->input('categories', []);
            $categoryIds = Category::whereIn('slug', $selectedSlugs)->pluck('id')->toArray();

            if (!empty($categoryIds)) {
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            }
        }

        if ($request->boolean('verified_only')) {
            $query->where('is_verified', true);
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
        $categories = Category::all();

        return view('professionals.index', [
            'professionals' => $professionals,
            'categories' => $categories,
            'allCategories' => $categories,
        ]);
    }
}
