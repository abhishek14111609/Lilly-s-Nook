<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:150'],
        ]);

        $subscriber = NewsletterSubscriber::query()->firstOrNew([
            'email' => $validated['email'],
        ]);

        $subscriber->source = $request->input('source', 'website');
        $subscriber->ip_address = $request->ip();
        $subscriber->status = 'active';

        if (Auth::check() && ! $subscriber->user_id) {
            $subscriber->user_id = Auth::id();
        }

        $subscriber->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Thanks for subscribing to the newsletter!',
            ]);
        }

        return back()->with('status', 'Thanks for subscribing to the newsletter!');
    }
}
