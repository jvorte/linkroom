<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Main categories (no parent)
        $mainCategories = [
            'IT / Technology',
            'Technical Trades / Construction',
            'Health & Care',
            'Education',
            'Professional Services',
            'Arts & Creative',
            'Commerce & Marketing',
            'Transportation & Logistics',
            'Hospitality & Tourism',
            'Cleaning & Security',
        ];

        $mainCategoryIds = [];

        // Create main categories
        foreach ($mainCategories as $mainCategoryName) {
            $category = Category::create([
                'name' => $mainCategoryName,
                'slug' => Str::slug($mainCategoryName),
                'parent_id' => null,
            ]);
            $mainCategoryIds[$mainCategoryName] = $category->id;
        }

        // Subcategories with parent_id
        $subcategories = [
            'IT / Technology' => [
                'Software Development',
                'Web Development',
                'Networking & Infrastructure',
                'Information Security',
                'Technical Support / Helpdesk',
                'Data Analysis / Data Science',
                'Artificial Intelligence / Machine Learning',
                'DevOps / Cloud Computing',
            ],
            'Technical Trades / Construction' => [
                'Electricians',
                'Plumbers',
                'Carpenters / Plasterers',
                'Engineers',
                'Insulation / Thermal Protection',
                'Construction & Renovations',
                'Painters',
            ],
            'Health & Care' => [
                'General Practitioners',
                'Dentists',
                'Nurses',
                'Physiotherapists',
                'Psychologists / Psychiatrists',
                'Nutritionists / Dietitians',
                'Ophthalmologists',
            ],
            'Education' => [
                'Primary School Teachers',
                'Secondary School Teachers',
                'Private Tutors',
                'Foreign Language Teaching',
                'Arts Education',
                'Adult Education',
            ],
            'Professional Services' => [
                'Lawyers',
                'Accountants / Tax Advisors',
                'Business Consultants',
                'Real Estate Agents',
                'Financial Advisors',
                'Translators',
            ],
            'Arts & Creative' => [
                'Photographers',
                'Graphic Designers',
                'Fashion Designers',
                'Directors / Videographers',
                'Musicians / DJs',
                'Actors / Theater Performers',
            ],
            'Commerce & Marketing' => [
                'Sales',
                'Marketing / Social Media',
                'Public Relations',
                'E-commerce',
                'Event Planning',
            ],
            'Transportation & Logistics' => [
                'Truck Drivers',
                'Delivery Drivers',
                'Warehouse Staff',
                'Logistics Coordinators',
                'Fleet Managers',
            ],
            'Hospitality & Tourism' => [
                'Hotel Staff',
                'Tour Guides',
                'Chefs / Cooks',
                'Waiters / Waitresses',
                'Travel Agents',
            ],
            'Cleaning & Security' => [
                'Cleaners',
                'Security Guards',
                'Janitors',
                'Maintenance Staff',
            ],
        ];

        // Create subcategories
        foreach ($subcategories as $parentName => $subs) {
            $parentId = $mainCategoryIds[$parentName];
            foreach ($subs as $subName) {
                Category::create([
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'parent_id' => $parentId,
                ]);
            }
        }
    }
}
