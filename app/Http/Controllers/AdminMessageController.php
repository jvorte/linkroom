<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class AdminMessageController extends Controller
{
public function destroy($id)
{
    $message = ContactMessage::findOrFail($id);
    $message->delete();

    return redirect()->back()->with('success', 'Message deleted successfully.');
}

}
