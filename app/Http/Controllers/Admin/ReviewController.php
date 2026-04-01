<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.index', [
            'reviews' => Review::query()->orderBy('sort_order', 'asc')->orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.reviews.form', [
            'review' => new Review(),
            'action' => route('admin.reviews.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateReview($request);
        Review::create($validated);

        return redirect()->route('admin.reviews.index')->with('status', 'Testimonial created successfully.');
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.form', [
            'review' => $review,
            'action' => route('admin.reviews.update', $review),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $validated = $this->validateReview($request);
        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('status', 'Testimonial updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('status', 'Testimonial deleted successfully.');
    }

    private function validateReview(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
