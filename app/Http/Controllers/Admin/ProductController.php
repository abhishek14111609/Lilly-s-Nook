<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'category.parent', 'subcategory']);
        $search = trim($request->string('search')->toString());
        $categoryId = $request->integer('category_id');

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($categoryId > 0) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::query()->whereNull('parent_id', 'and', false)->with('children')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::query()
                ->whereNull('parent_id', 'and', false)
                ->with(['subcategories' => fn($query) => $query->orderBy('name')])
                ->orderBy('name')
                ->get(),
            'subcategories' => Subcategory::query()->with('category:id,name')->orderBy('name')->get(),
            'action' => route('admin.products.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request, false, null);
        $subcategory = Subcategory::query()->findOrFail($validated['subcategory_id']);
        $validated['category_id'] = $subcategory->category_id;

        if ($request->hasFile('image_file')) {
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/products');
        }

        if ($request->hasFile('video_file')) {
            $validated['video'] = $this->storeVideo($request, 'video_file', 'uploads/videos');
        }

        if (empty($validated['image'])) {
            throw ValidationException::withMessages(['image_file' => 'Please upload a product image.']);
        }

        $product = Product::create($validated);

        $variants = $request->input('variants', []);
        if (is_array($variants)) {
            foreach ($variants as $variantData) {
                if (!empty($variantData['size']) || !empty($variantData['color'])) {
                    $product->variants()->create($variantData);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully with variants!');
    }

    public function edit(Product $product)
    {
        $product->load(['variants', 'subcategory']);
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::query()
                ->whereNull('parent_id', 'and', false)
                ->with(['subcategories' => fn($query) => $query->orderBy('name')])
                ->orderBy('name')
                ->get(),
            'subcategories' => Subcategory::query()->with('category:id,name')->orderBy('name')->get(),
            'action' => route('admin.products.update', $product),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, true, $product);
        $subcategory = Subcategory::query()->findOrFail($validated['subcategory_id']);
        $validated['category_id'] = $subcategory->category_id;

        if ($request->hasFile('image_file')) {
            $this->deleteUploadedImage($product->image);
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/products');
        } else {
            $validated['image'] = $product->image;
        }

        if ($request->hasFile('video_file')) {
            $this->deleteUploadedVideo($product->video);
            $validated['video'] = $this->storeVideo($request, 'video_file', 'uploads/videos');
        } else {
            $validated['video'] = $validated['video'] ?? $product->video;
        }

        $product->update($validated);

        // Update Variants
        $variants = $request->input('variants', []);
        if (is_array($variants)) {
            $product->variants()->delete(); // Re-create simple for now, or sync complex
            foreach ($variants as $variantData) {
                if (!empty($variantData['size']) || !empty($variantData['color'])) {
                    $product->variants()->create($variantData);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('status', 'Product and variants updated successfully.');
    }

    public function destroy(Product $product)
    {
        Product::query()->whereKey($product->getKey())->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully.');
    }

    private function validateProduct(Request $request, bool $isUpdate = false, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,bmp,arw', 'max:20480'],
            'video' => ['nullable', 'string', 'max:255'],
            'video_file' => ['nullable', 'file', 'mimes:mp4', 'max:102400'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'variants' => ['nullable', 'array'],
            'variants.*.size' => ['nullable', 'string'],
            'variants.*.color' => ['nullable', 'string'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.price_modifier' => ['nullable', 'numeric'],
        ]);
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
