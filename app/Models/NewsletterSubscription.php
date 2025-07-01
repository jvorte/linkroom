<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NewsletterSubscription extends Model
{
  protected $fillable = ['email'];
}
