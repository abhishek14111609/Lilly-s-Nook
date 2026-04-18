<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->string('search')->toString());
        $type = $request->string('type')->toString();

        $baseQuery = Category::query()
            ->with(['parent:id,name'])
            ->withCount('subcategories', 'products')
            ->orderBy('name', 'asc');

        $stats = [
            'main_categories' => Category::query()->whereNull('parent_id', 'and', false)->count(),
            'subcategories' => Subcategory::query()->get(['id'])->count(),
            'total_products' => Product::query()->get(['id'])->count(),
        ];

        if ($search !== '') {
            $baseQuery->where(function ($query) use ($search): void {
                $query
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        if ($type === 'sub') {
            $baseQuery->whereNotNull('parent_id', 'and', false);
        }

        $categoryTree = $baseQuery
            ->with([
                'subcategories' => fn($query) => $query
                    ->withCount('products')
                    ->orderBy('name', 'asc'),
            ])
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => collect(),
            'categoryTree' => $categoryTree,
            'type' => $type,
            'search' => $search,
            'stats' => $stats,
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

        $parentCategory = Category::query()->whereNull('parent_id', 'and', false)->find($validated['parent_id']);

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
        $parentCategories = Category::query()->whereNull('parent_id', 'and', false)->orderBy('name', 'asc')->get();
        return view('admin.categories.form', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,bmp,arw|max:20480',
            'video' => 'nullable|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4|max:102400',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/categories');
        }

        if ($request->hasFile('video_file')) {
            $validated['video'] = $this->storeVideo($request, 'video_file', 'uploads/videos');
        }

        $validated['slug'] = Str::slug($validated['name']);

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Category::where('slug', '=', $validated['slug'], 'and')->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::query()->whereNull('parent_id', 'and', false)
            ->where('id', '!=', $category->id)
            ->orderBy('name', 'asc')
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
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,bmp,arw|max:20480',
            'video' => 'nullable|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4|max:102400',
        ]);

        if ($request->hasFile('image_file')) {
            $this->deleteUploadedImage($category->image);
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/categories');
        } else {
            $validated['image'] = $validated['image'] ?: $category->image;
        }

        if ($request->hasFile('video_file')) {
            $this->deleteUploadedVideo($category->video);
            $validated['video'] = $this->storeVideo($request, 'video_file', 'uploads/videos');
        } else {
            $validated['video'] = $validated['video'] ?? $category->video;
        }

        if ($request->string('name')->toString() !== (string) $category->name) {
            $validated['slug'] = Str::slug($validated['name']);
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Category::where('slug', '=', $validated['slug'], 'and')->where('id', '!=', $category->id, 'and')->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->deleteUploadedImage($category->image);
        $this->deleteUploadedVideo($category->video);
        Category::query()->whereKey($category->getKey())->delete();
        return redirect()->route('admin.categories.index')
            ->with('status', 'Category deleted successfully!');
    }

    private function storeImage(Request $request, string $field, string $directory): string
    {
        $file = $request->file($field);
        $name = Str::uuid()->toString() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = strtolower((string) $file->getClientOriginalExtension());

        $targetDirectory = public_path('images/' . trim($directory, '/'));
        if (! is_dir($targetDirectory) && ! @mkdir($targetDirectory, 0777, true) && ! is_dir($targetDirectory)) {
            throw ValidationException::withMessages(['image_file' => 'Unable to create image upload directory.']);
        }

        if ($extension === 'arw') {
            $filename = $name . '.jpg';
            $this->convertRawToJpeg($file->getPathname(), $targetDirectory . DIRECTORY_SEPARATOR . $filename);

            return trim($directory, '/') . '/' . $filename;
        }

        $filename = $name . '.' . $extension;

        $file->move($targetDirectory, $filename);

        return trim($directory, '/') . '/' . $filename;
    }

    private function convertRawToJpeg(string $inputPath, string $outputPath): void
    {
        $imagickClass = 'Imagick';

        if (! class_exists($imagickClass)) {
            throw ValidationException::withMessages([
                'image_file' => 'ARW upload requires Imagick with RAW codec support. Install/enable Imagick to use .arw files.',
            ]);
        }

        try {
            $imagick = new $imagickClass($inputPath . '[0]');
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompressionQuality(90);
            $imagick->stripImage();
            $imagick->writeImage($outputPath);
            $imagick->clear();
            $imagick->destroy();
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                'image_file' => 'Unable to convert ARW image. Please convert to JPG/WEBP or verify Imagick RAW support.',
            ]);
        }
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

    private function storeVideo(Request $request, string $field, string $directory): string
    {
        $file = $request->file($field);
        $name = Str::uuid()->toString() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $name . '.mp4';

        $targetDirectory = public_path(trim($directory, '/'));
        if (! is_dir($targetDirectory) && ! @mkdir($targetDirectory, 0777, true) && ! is_dir($targetDirectory)) {
            throw ValidationException::withMessages(['video_file' => 'Unable to create video upload directory.']);
        }

        $file->move($targetDirectory, $filename);

        return trim($directory, '/') . '/' . $filename;
    }

    private function deleteUploadedVideo(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/')) {
            return;
        }

        $fullPath = public_path($path);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
