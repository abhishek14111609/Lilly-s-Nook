<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.sliders.index', [
            'sliders' => HomeSlider::query()->orderBy('sort_order', 'asc')->orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.sliders.form', [
            'slider' => new HomeSlider(),
            'action' => route('admin.sliders.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSlider($request);

        if ($request->hasFile('image_file')) {
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/sliders');
        }

        if (empty($validated['image'])) {
            throw ValidationException::withMessages(['image_file' => 'Please upload a slider image.']);
        }

        HomeSlider::create($validated);

        return redirect()->route('admin.sliders.index')->with('status', 'Slider created successfully.');
    }

    public function edit(HomeSlider $slider)
    {
        return view('admin.sliders.form', [
            'slider' => $slider,
            'action' => route('admin.sliders.update', $slider),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, HomeSlider $slider)
    {
        $validated = $this->validateSlider($request);

        if ($request->hasFile('image_file')) {
            $this->deleteUploadedImage($slider->image);
            $validated['image'] = $this->storeImage($request, 'image_file', 'uploads/sliders');
        } else {
            $validated['image'] = $slider->image;
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('status', 'Slider updated successfully.');
    }

    public function destroy(HomeSlider $slider)
    {
        $this->deleteUploadedImage($slider->image);
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('status', 'Slider deleted successfully.');
    }

    private function validateSlider(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
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
