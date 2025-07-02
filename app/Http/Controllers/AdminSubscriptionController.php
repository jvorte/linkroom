<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;

class AdminSubscriptionController extends Controller
{
    public function destroy($id)
{
    $subscription = NewsletterSubscription::findOrFail($id);
    $subscription->delete();

    return redirect()->back()->with('success', 'Subscription deleted successfully.');
}

}
