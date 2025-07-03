<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
   protected $fillable = ['name', 'slug', 'parent_id'];



        // Σχέση προς γονική κατηγορία (1 parent)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Σχέση προς υποκατηγορίες (πολλές children)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
