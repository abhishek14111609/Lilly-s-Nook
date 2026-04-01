<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $parentId = $request->integer('parent_id');
        $parentOptions = Category::query()->whereNull('parent_id')->orderBy('name')->get(['id', 'name']);

        if ($parentId > 0) {
            $categories = Category::query()
                ->with(['parent', 'products'])
                ->where('parent_id', $parentId)
                ->latest()
                ->paginate(20)
                ->withQueryString();

            return view('admin.categories.index', [
                'categories' => $categories,
                'categoryTree' => collect(),
                'parentOptions' => $parentOptions,
            ]);
        }

        $categoryTree = Category::query()
            ->whereNull('parent_id')
            ->withCount('products')
            ->with([
                'children' => fn($query) => $query->withCount('products')->orderBy('name'),
            ])
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => collect(),
            'categoryTree' => $categoryTree,
            'parentOptions' => $parentOptions,
        ]);
    }

    public function setParent(Request $request, Category $category)
    {
        if ($category->children()->exists()) {
            return back()->withErrors(['category' => 'Please move or remove subcategories first before converting this category.']);
        }

        $validated = $request->validate([
            'parent_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $parentCategory = Category::query()->whereNull('parent_id')->find($validated['parent_id']);

        if (!$parentCategory || $parentCategory->id === $category->id) {
            return back()->withErrors(['parent_id' => 'Please choose a valid main category.']);
        }

        $category->update(['parent_id' => $parentCategory->id]);

        return back()->with('status', 'Category moved under main category successfully.');
    }

    public function makeMain(Category $category)
    {
        $category->update(['parent_id' => null]);

        return back()->with('status', 'Category moved to main categories successfully.');
    }

    public function create()
    {
        $parentCategories = Category::query()->whereNull('parent_id')->get();
        return view('admin.categories.form', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/categories');
        }

        $validated['slug'] = Str::slug($validated['name']);

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::query()->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
        return view('admin.categories.form', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image_file')) {
            $this->deleteUploadedImage($category->image);
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/categories');
        } else {
            $validated['image'] = $validated['image'] ?: $category->image;
        }

        if ($request->string('name')->toString() !== (string) $category->name) {
            $validated['slug'] = Str::slug($validated['name']);
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Category::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('status', 'Category deleted successfully!');
    }

    private function storeImage(Request $request, string $field, string $directory): string
    {
        $file = $request->file($field);
        $name = Str::uuid()->toString() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $name . '.' . $file->getClientOriginalExtension();

        $targetDirectory = public_path('images/' . trim($directory, '/'));
        if (! is_dir($targetDirectory) && ! @mkdir($targetDirectory, 0777, true) && ! is_dir($targetDirectory)) {
            throw new \RuntimeException('Unable to create image upload directory.');
        }

        $file->move($targetDirectory, $filename);

        return trim($directory, '/') . '/' . $filename;
    }

    private function deleteUploadedImage(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/')) {
            return;
        }

        $fullPath = public_path('images/' . $path);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
