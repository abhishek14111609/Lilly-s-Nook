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

        if ($request->hasFile('video_file')) {
            $validated['video'] = $this->storeVideo($request, 'video_file', 'uploads/videos');
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

        if ($request->hasFile('video_file')) {
            $this->deleteUploadedVideo($slider->video);
            $validated['video'] = $this->storeVideo($request, 'video_file', 'uploads/videos');
        } else {
            $validated['video'] = $validated['video'] ?? $slider->video;
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('status', 'Slider updated successfully.');
    }

    public function destroy(HomeSlider $slider)
    {
        $this->deleteUploadedImage($slider->image);
        $this->deleteUploadedVideo($slider->video);
        HomeSlider::query()->whereKey($slider->getKey())->delete();

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
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,bmp,arw', 'max:20480'],
            'video' => ['nullable', 'string', 'max:255'],
            'video_file' => ['nullable', 'file', 'mimes:mp4', 'max:102400'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
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
