<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\Category;

class User extends Authenticatable
{
   
   
   
   protected static function booted()
{
    static::saving(function ($user) {
        if (empty($user->slug)) {
            $user->slug = Str::slug($user->name);

            // Αν υπάρχει ήδη το slug, πρόσθεσε αριθμό για μοναδικότητα
            $count = 1;
            $baseSlug = $user->slug;

            while (static::where('slug', $user->slug)->where('id', '!=', $user->id)->exists()) {
                $user->slug = $baseSlug . '-' . $count++;
            }
        }
    });
}

public function categories()
{
    return $this->belongsToMany(Category::class);
}

   
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function links()
{
    return $this->hasMany(Link::class)->orderBy('order');
}


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'name',
    'email',
    'password',
    'bio',
    'public_email',
    'phone',
    'avatar',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
