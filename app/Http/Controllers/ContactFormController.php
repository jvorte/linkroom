<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactFormController extends Controller
{
    public function show() {
        return view('contact');
    }

    public function submit(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($request->only('name', 'email', 'message'));

        return back()->with('success', 'The message was sent successfully!');
    }
}
