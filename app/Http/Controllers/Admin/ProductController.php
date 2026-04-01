<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'category.parent']);
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
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
            'action' => route('admin.products.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request, false, null);

        if ($request->hasFile('image_file')) {
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/products');
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
        $product->load('variants');
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
            'action' => route('admin.products.update', $product),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, true, $product);

        if ($request->hasFile('image_file')) {
            $this->deleteUploadedImage($product->image);
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/products');
        } else {
            $validated['image'] = $product->image;
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
        $product->delete();

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
            'image_file' => ['nullable', 'image', 'max:4096'],
            'category_id' => ['required', 'exists:categories,id'],
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
        $filename = $name . '.' . $file->getClientOriginalExtension();

        $targetDirectory = public_path('images/' . trim($directory, '/'));
        if (! is_dir($targetDirectory) && ! @mkdir($targetDirectory, 0777, true) && ! is_dir($targetDirectory)) {
            throw ValidationException::withMessages(['image_file' => 'Unable to create image upload directory.']);
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
