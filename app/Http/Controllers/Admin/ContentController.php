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
        $defaultAgeGroups = ['2-3 years', '3-4 years', '4-5 years', '5-6 years', '6-7 years'];
        $defaultCollections = [
            'Whimsical New Arrivals',
            'Bestselling Classics',
            'Occasion Dresses with a Vintage Twist',
        ];
        $defaultPromiseItems = [
            "Style that's as unique as your little one",
            'Care for the planet, with every stitch',
            'Joy in every outfit, because childhood is magic',
        ];

        return view('admin.content.edit', [
            'content' => [
                'home_intro_text' => SiteSetting::getValue('home_intro_text', "Step into the enchanting world of Lily's Nook, where delicate lace, soft pastels, and timeless silhouettes come together in a celebration of childhood whimsy. Our carefully crafted collections evoke the elegance of a bygone era, with a playful twist that perfectly captures the spirit of little girls who light up the world."),
                'home_age_groups_text' => implode("\n", SiteSetting::getJson('home_age_groups', $defaultAgeGroups)),
                'home_about_kicker' => SiteSetting::getValue('home_about_kicker', "Welcome to Lilly's Nook"),
                'home_about_title' => SiteSetting::getValue('home_about_title', "Where yesterday's charm meets today's little star"),
                'home_about_description' => SiteSetting::getValue('home_about_description', "Inspired by whispers of the past, Lilly's Nook curates enchanting outfits that spark wonder in the hearts of curious, stylish girls."),
                'home_story_title' => SiteSetting::getValue('home_story_title', 'Our Story'),
                'home_collections_title' => SiteSetting::getValue('home_collections_title', 'Shop Our Timeless Collections'),
                'home_collections_items_text' => implode("\n", SiteSetting::getJson('home_collections_items', $defaultCollections)),
                'about_title' => SiteSetting::getValue('about_title', "About Lily's Nook"),
                'about_body_one' => SiteSetting::getValue('about_body_one', "Lily's Nook is a celebration of childhood's magic, crafted with love for little ones who shine bright."),
                'about_body_two' => SiteSetting::getValue('about_body_two', "We curate timeless, whimsical outfits that spark imagination and wonder. With a focus on sustainable style and quality craftsmanship, we're here to make dressing dreams effortless for you and enchanting for them."),
                'about_promise_title' => SiteSetting::getValue('about_promise_title', 'Our Promise'),
                'about_promise_items_text' => implode("\n", SiteSetting::getJson('about_promise_items', $defaultPromiseItems)),
                'about_image' => SiteSetting::getValue('about_image', 'collection-item1.jpg'),
                'contact_heading' => SiteSetting::getValue('contact_heading', 'Get in touch'),
                'contact_description' => SiteSetting::getValue('contact_description', "Have a question or need assistance? We're here to help you with anything from product inquiries to order support."),
                'contact_phone' => SiteSetting::getValue('contact_phone', '+91 9106005682'),
                'contact_email' => SiteSetting::getValue('contact_email', 'info@lillysnook.com'),
                'contact_address' => SiteSetting::getValue('contact_address', 'Rajkot, Gujarat, India'),
            ],
            'whyChooseUs' => SiteSetting::getJson('home_why_choose_us', [
                ['title' => 'Handpicked designs that spark joy', 'description' => 'Curated pieces that celebrate wonder, playfulness, and personality.', 'icon' => 'icon icon-check-circle'],
                ['title' => 'Timeless elegance with a whimsical twist', 'description' => 'Vintage-inspired silhouettes made for modern little trendsetters.', 'icon' => 'icon icon-star'],
                ['title' => 'Quality craftsmanship for little treasures', 'description' => 'Soft fabrics and thoughtful finishing built for comfort and durability.', 'icon' => 'icon icon-user'],
                ['title' => 'Curated with love, for the little ones', 'description' => 'Every collection is selected to keep childhood style magical and effortless.', 'icon' => 'icon icon-heart'],
            ]),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'home_intro_text' => ['required', 'string'],
            'home_age_groups_text' => ['required', 'string'],
            'home_about_kicker' => ['nullable', 'string', 'max:255'],
            'home_about_title' => ['required', 'string', 'max:255'],
            'home_about_description' => ['required', 'string'],
            'home_story_title' => ['required', 'string', 'max:255'],
            'home_collections_title' => ['required', 'string', 'max:255'],
            'home_collections_items_text' => ['required', 'string'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_body_one' => ['required', 'string'],
            'about_body_two' => ['nullable', 'string'],
            'about_promise_title' => ['required', 'string', 'max:255'],
            'about_promise_items_text' => ['required', 'string'],
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

        foreach (['home_intro_text', 'home_about_kicker', 'home_about_title', 'home_about_description', 'home_story_title', 'home_collections_title', 'about_title', 'about_body_one', 'about_body_two', 'about_promise_title', 'about_image', 'contact_heading', 'contact_description', 'contact_phone', 'contact_email', 'contact_address'] as $key) {
            SiteSetting::setValue($key, $validated[$key] ?? null);
        }

        SiteSetting::setJson('home_age_groups', $this->parseLines($validated['home_age_groups_text'] ?? ''));
        SiteSetting::setJson('home_collections_items', $this->parseLines($validated['home_collections_items_text'] ?? ''));
        SiteSetting::setJson('about_promise_items', $this->parseLines($validated['about_promise_items_text'] ?? ''));

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

    private function parseLines(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $value) ?: [])
            ->map(static fn(string $line): string => trim($line))
            ->filter(static fn(string $line): bool => $line !== '')
            ->values()
            ->all();
    }
}
