<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::with('user');

        // Search by email
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('email', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }

        // Filter by source
        if ($request->has('source') && $request->input('source') !== '') {
            $query->where('source', $request->input('source'));
        }

        // Sort
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (in_array($sortBy, ['created_at', 'email', 'status', 'source'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $subscribers = $query->paginate(20);

        return view('admin.newsletter-subscribers.index', compact('subscribers'));
    }
}
