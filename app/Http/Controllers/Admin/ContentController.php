<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function edit()
    {
        return view('admin.content.edit', [
            'content' => [
                'home_about_kicker' => SiteSetting::getValue('home_about_kicker', "About Lilly's Nook"),
                'home_about_title' => SiteSetting::getValue('home_about_title', 'Elegant fashion, crafted to make every day feel special'),
                'home_about_description' => SiteSetting::getValue('home_about_description', "Lilly's Nook blends modern silhouettes with timeless charm. We design thoughtfully, source quality fabrics, and focus on comfort so every piece looks graceful and feels effortless."),
                'about_title' => SiteSetting::getValue('about_title', 'Established in 2024'),
                'about_body_one' => SiteSetting::getValue('about_body_one', ''),
                'about_body_two' => SiteSetting::getValue('about_body_two', ''),
                'about_image' => SiteSetting::getValue('about_image', 'collection-item1.jpg'),
                'contact_heading' => SiteSetting::getValue('contact_heading', 'Get in touch'),
                'contact_description' => SiteSetting::getValue('contact_description', "Have a question or need assistance? We're here to help you with anything from product inquiries to order support."),
                'contact_phone' => SiteSetting::getValue('contact_phone', '+91 9106005682'),
                'contact_email' => SiteSetting::getValue('contact_email', 'info@lillysnook.com'),
                'contact_address' => SiteSetting::getValue('contact_address', 'Rajkot, Gujarat, India'),
            ],
            'whyChooseUs' => SiteSetting::getJson('home_why_choose_us', [
                ['title' => 'Premium Fabrics', 'description' => 'Soft-touch, long-lasting materials selected for comfort and confidence.', 'icon' => 'icon icon-check-circle'],
                ['title' => 'Curated Collections', 'description' => 'Timeless silhouettes and modern trends chosen for versatile styling.', 'icon' => 'icon icon-star'],
                ['title' => 'Trusted Service', 'description' => 'Secure checkout, responsive support, and smooth order tracking.', 'icon' => 'icon icon-user'],
            ]),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'home_about_kicker' => ['nullable', 'string', 'max:255'],
            'home_about_title' => ['required', 'string', 'max:255'],
            'home_about_description' => ['required', 'string'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_body_one' => ['required', 'string'],
            'about_body_two' => ['nullable', 'string'],
            'about_image' => ['nullable', 'string', 'max:255'],
            'about_image_file' => ['nullable', 'image', 'max:4096'],
            'contact_heading' => ['required', 'string', 'max:255'],
            'contact_description' => ['required', 'string'],
            'contact_phone' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_address' => ['required', 'string', 'max:255'],
            'why_choose_title' => ['nullable', 'array'],
            'why_choose_title.*' => ['nullable', 'string', 'max:255'],
            'why_choose_description' => ['nullable', 'array'],
            'why_choose_description.*' => ['nullable', 'string'],
            'why_choose_icon' => ['nullable', 'array'],
            'why_choose_icon.*' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('about_image_file')) {
            $existing = SiteSetting::getValue('about_image');
            $this->deleteUploadedImage($existing);
            $validated['about_image'] = $this->storeImage($request, 'about_image_file', 'uploads/about');
        }

        if (empty($validated['about_image'])) {
            $validated['about_image'] = SiteSetting::getValue('about_image', 'collection-item1.jpg');
        }

        foreach (['home_about_kicker', 'home_about_title', 'home_about_description', 'about_title', 'about_body_one', 'about_body_two', 'about_image', 'contact_heading', 'contact_description', 'contact_phone', 'contact_email', 'contact_address'] as $key) {
            SiteSetting::setValue($key, $validated[$key] ?? null);
        }

        $items = [];
        $titles = $validated['why_choose_title'] ?? [];
        $descriptions = $validated['why_choose_description'] ?? [];
        $icons = $validated['why_choose_icon'] ?? [];

        $max = max(count($titles), count($descriptions), count($icons));
        for ($i = 0; $i < $max; $i++) {
            $title = trim((string) ($titles[$i] ?? ''));
            $description = trim((string) ($descriptions[$i] ?? ''));
            $icon = trim((string) ($icons[$i] ?? 'icon icon-star'));

            if ($title === '' && $description === '') {
                continue;
            }

            $items[] = [
                'title' => $title,
                'description' => $description,
                'icon' => $icon !== '' ? $icon : 'icon icon-star',
            ];
        }

        SiteSetting::setJson('home_why_choose_us', $items);

        return redirect()->route('admin.content.edit')->with('status', 'Site content updated successfully.');
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
