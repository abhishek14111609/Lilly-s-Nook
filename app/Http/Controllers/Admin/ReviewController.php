<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $search = trim($request->string('search')->toString());

        $query = Review::query()
            ->with(['product:id,name', 'user:id,name,email'])
            ->orderByRaw('CASE WHEN product_id IS NULL THEN 1 ELSE 0 END ASC')
            ->orderByDesc('id');

        if ($status === 'pending') {
            $query->where('is_active', false);
        }

        if ($status === 'approved') {
            $query->where('is_active', true);
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('quote', 'like', '%' . $search . '%')
                    ->orWhereHas('product', fn($productQuery) => $productQuery->where('name', 'like', '%' . $search . '%'));
            });
        }

        return view('admin.reviews.index', [
            'reviews' => $query->paginate(15)->withQueryString(),
            'statusFilter' => $status,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('admin.reviews.form', [
            'review' => new Review(),
            'products' => Product::query()->orderBy('name', 'asc')->get(['id', 'name']),
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
            'products' => Product::query()->orderBy('name', 'asc')->get(['id', 'name']),
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
        Review::query()->whereKey($review->getKey())->delete();

        return redirect()->route('admin.reviews.index')->with('status', 'Review deleted successfully.');
    }

    public function toggleStatus(Review $review)
    {
        $review->update([
            'is_active' => ! $review->is_active,
        ]);

        return redirect()
            ->route('admin.reviews.index')
            ->with('status', $review->is_active ? 'Review approved and visible now.' : 'Review hidden successfully.');
    }

    private function validateReview(Request $request): array
    {
        return $request->validate([
            'product_id' => ['nullable', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
