<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::query()
            ->with('category:id,name')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        return view('admin.subcategories.form', [
            'subcategory' => new Subcategory(),
            'categories' => $this->mainCategories(),
            'action' => route('admin.subcategories.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSubcategory($request);
        $validated['slug'] = $this->makeUniqueSlug($validated['name']);

        Subcategory::create($validated);

        return redirect()->route('admin.subcategories.index')->with('status', 'Subcategory created successfully!');
    }

    public function edit(Subcategory $subcategory)
    {
        return view('admin.subcategories.form', [
            'subcategory' => $subcategory,
            'categories' => $this->mainCategories($subcategory->category_id),
            'action' => route('admin.subcategories.update', $subcategory),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $this->validateSubcategory($request);

        if ($subcategory->name !== $validated['name']) {
            $validated['slug'] = $this->makeUniqueSlug($validated['name'], $subcategory->id);
        }

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories.index')->with('status', 'Subcategory updated successfully!');
    }

    public function destroy(Subcategory $subcategory)
    {
        if ($subcategory->products()->exists()) {
            return back()->withErrors(['subcategory' => 'Please move or remove products before deleting this subcategory.']);
        }

        Subcategory::query()->whereKey($subcategory->getKey())->delete();

        return redirect()->route('admin.subcategories.index')->with('status', 'Subcategory deleted successfully!');
    }

    private function validateSubcategory(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
    }

    private function mainCategories(?int $exceptId = null)
    {
        return Category::query()
            ->whereNull('parent_id', 'and', false)
            ->when($exceptId, fn($query) => $query->orWhereKey($exceptId))
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Subcategory::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
