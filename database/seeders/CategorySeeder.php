<?php

//  php artisan db:seed --class=CategorySeeder

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $mainCategories = [
            'IT / Technology',
            'Pets',
            'Technical Trades / Construction',
            'Health & Care',
            'Education',
            'Professional Services',
            'Arts & Creative',
            'Commerce & Marketing',
            'Transportation & Logistics',
            'Hospitality & Tourism',
            'Cleaning & Security',
            'Other',  // Νέα κατηγορία
        ];

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
                'Database Administration',
                'System Administration',
                'Quality Assurance / Testing',
                'Mobile Development',
                'UI/UX Design',
            ],
                  'Pets' => [
                'Dog Trainers',
                'Cat Trainers',
                'Pet Groomers',
                'Pet Sitters',
                'Animal Caretakers',
                'Veterinarians',
                'Pet Boarding / Kennels',
                'Pet Nutritionists',
                'Pet Behaviorists',
                'Exotic Animal Specialists',
            ],
            'Technical Trades / Construction' => [
                'Electricians',
                'Plumbers',
                'Carpenters / Plasterers',
                'Engineers',
                'Insulation / Thermal Protection',
                'Construction & Renovations',
                'Painters',
                'Masons',
                'Roofers',
                'HVAC Technicians',
                'Heavy Equipment Operators',
            ],
            'Health & Care' => [
                'General Practitioners',
                'Dentists',
                'Nurses',
                'Physiotherapists',
                'Psychologists / Psychiatrists',
                'Nutritionists / Dietitians',
                'Ophthalmologists',
                'Pharmacists',
                'Medical Assistants',
                'Emergency Medical Technicians (EMTs)',
                'Speech Therapists',
                
                'Caregivers / Home Health Aides',
                'Nutrition Coaches',
                'Fitness Coaches',
            ],
            'Education' => [
                'Primary School Teachers',
                'Secondary School Teachers',
                'Private Tutors',
                'Foreign Language Teaching',
                'Arts Education',
                'Adult Education',
                'Special Education Teachers',
                'Educational Counselors',
            ],
            'Professional Services' => [
                'Lawyers',
                'Accountants / Tax Advisors',
                'Business Consultants',
                'Secretary',
                'Real Estate Agents',
                'Financial Advisors',
                'Translators',
                'HR Specialists',
                'Project Managers',
            ],
            'Arts & Creative' => [
                'Photographers',
                'Graphic Designers',
                'Fashion Designers',
                'Directors / Videographers',
                'Musicians / DJs',
                'Actors / Theater Performers',
                'Writers / Authors',
                'Illustrators',
                'Animators',
                'Tattoo Artists',
                'Personal Trainers',
                'Pet Trainers',
                'Makeup Artists',
                'Hair Stylists',
                'Yoga Instructors',
                'Dance Instructors',
                'Massage Therapists',
            ],
            'Commerce & Marketing' => [
                'Sales',
                'Marketing / Social Media',
                'Public Relations',
                'E-commerce',
                'Event Planning',
                'Market Research Analysts',
                'Content Creators',
                'Advertising Specialists',
            ],
            'Transportation & Logistics' => [
                'Truck Drivers',
                'Delivery Drivers',
                'Warehouse Staff',
                'Logistics Coordinators',
                'Fleet Managers',
                'Customs Brokers',
                'Shipping Clerks',
            ],
            'Hospitality & Tourism' => [
                'Hotel Staff',
                'Tour Guides',
                'Chefs / Cooks',
                'Waiters / Waitresses',
                'Travel Agents',
                'Event Coordinators',
                'Concierges',
            ],
            'Cleaning & Security' => [
                'Cleaners',
                'Security Guards',
                'Janitors',
                'Maintenance Staff',
                'Alarm System Technicians',
            ],
            'Other' => [  // Νέα κατηγορία με υποκατηγορίες
                'General Worker',
                'Freelancer',
                'Temporary Staff',
                'Consultant',
                'Volunteer',
                'Intern',
                'Freelance Writers',
                'Freelance Developers',
                'Influencers / Content Creators',
                'Startup Founders',
                'Remote Workers',
            ],
        ];

        $mainCategoryIds = [];

        DB::transaction(function () use ($mainCategories, $subcategories, &$mainCategoryIds) {
            foreach ($mainCategories as $mainCategoryName) {
                $category = Category::where('name', $mainCategoryName)->first();
                if (!$category) {
                    $category = Category::create([
                        'name' => $mainCategoryName,
                        'slug' => Str::slug($mainCategoryName),
                        'parent_id' => null,
                    ]);
                    $this->command->info("Main category created: {$mainCategoryName}");
                } else {
                    $this->command->info("Main category exists: {$mainCategoryName}");
                }
                $mainCategoryIds[$mainCategoryName] = $category->id;
            }

            foreach ($subcategories as $parentName => $subs) {
                $parentId = $mainCategoryIds[$parentName];
                foreach ($subs as $subName) {
                    $exists = Category::where('name', $subName)->where('parent_id', $parentId)->first();
                    if (!$exists) {
                        Category::create([
                            'name' => $subName,
                            'slug' => Str::slug($subName),
                            'parent_id' => $parentId,
                        ]);
                        $this->command->info("Subcategory created: {$subName} (parent: {$parentName})");
                    } else {
                        $this->command->info("Subcategory exists: {$subName} (parent: {$parentName})");
                    }
                }
            }
        });

        $this->command->info('Categories seeding completed!');
    }
}
