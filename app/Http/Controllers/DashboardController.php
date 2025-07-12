<?php

// DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscription;
use App\Models\User;
class DashboardController extends Controller
{
    use AuthorizesRequests;


    public function home()
    {
      

        return view('home');
    }

public function showJoinPage()
{
    $randomUsers = User::where('is_active', true)
    ->whereNotNull('avatar')
    ->inRandomOrder()
    ->limit(3)
    ->get();


    return view('join', compact('randomUsers'));
}



public function admin()
{
    $messages = ContactMessage::latest()->get();
    $subscriptions = NewsletterSubscription::latest()->get();

    return view('admin.index', compact('messages', 'subscriptions'));
}

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $url = $request->url;
        if (!Str::startsWith($url, ['http://', 'https://'])) {
            $url = 'https://' . $url;
        }

        Auth::user()->links()->create([
            'title' => $request->title,
            'url' => $url,
            'order' => $request->input('order') ?? 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Link added');
    }

    public function update(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $url = $request->url;
        if (!Str::startsWith($url, ['http://', 'https://'])) {
            $url = 'https://' . $url;
        }

        $link->update([
            'title' => $request->title,
            'url' => $url,
            'order' => $request->input('order') ?? $link->order,
        ]);

        return redirect()->route('dashboard')->with('success', 'Link updated');
    }

    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $link->delete();

        return redirect()->route('dashboard')->with('success', 'Link deleted');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|integer|exists:links,id',
            'order.*.order' => 'required|integer',
        ]);

        $user = auth()->user();

        foreach ($request->order as $item) {
            $link = $user->links()->where('id', $item['id'])->first();
            if ($link) {
                $link->order = $item['order'];
                $link->save();
            }
        }

        return response()->json(['status' => 'success']);
    }
}

