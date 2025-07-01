<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:newsletter_subscriptions,email']);

        NewsletterSubscription::create([
            'email' => $request->email,
        ]);

        return back()->with('success', 'Ευχαριστούμε για την εγγραφή σας!');
    }
}
