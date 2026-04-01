<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:150'],
        ]);

        NewsletterSubscriber::query()->firstOrCreate([
            'email' => $validated['email'],
        ]);

        return back()->with('status', 'Thanks for subscribing to the newsletter.');
    }
}
