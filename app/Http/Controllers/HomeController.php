<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Review;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $defaultWhyChooseUs = [
            [
                'title' => 'Premium Fabrics',
                'description' => 'Soft-touch, long-lasting materials selected for comfort and confidence.',
                'icon' => 'icon icon-check-circle',
            ],
            [
                'title' => 'Curated Collections',
                'description' => 'Timeless silhouettes and modern trends chosen for versatile styling.',
                'icon' => 'icon icon-star',
            ],
            [
                'title' => 'Trusted Service',
                'description' => 'Secure checkout, responsive support, and smooth order tracking.',
                'icon' => 'icon icon-user',
            ],
        ];

        $aboutContent = [
            'kicker' => SiteSetting::getValue('home_about_kicker', "About Lilly's Nook"),
            'title' => SiteSetting::getValue('home_about_title', 'Elegant fashion, crafted to make every day feel special'),
            'description' => SiteSetting::getValue('home_about_description', "Lilly's Nook blends modern silhouettes with timeless charm. We design thoughtfully, source quality fabrics, and focus on comfort so every piece looks graceful and feels effortless."),
        ];

        return view('home', [
            'sliders' => HomeSlider::query()->where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->get(),
            'featuredProducts' => Product::query()->latest()->take(8)->get(),
            'latestProducts' => Product::query()->latest()->take(4)->get(),
            'categories' => Category::query()
                ->whereNull('parent_id')
                ->with(['children' => fn($q) => $q->withCount('products')->orderBy('name')])
                ->withCount('products')
                ->orderBy('name')
                ->take(6)
                ->get(),
            'testimonials' => Review::query()
                ->where('is_active', true)
                ->whereNotNull('quote')
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->take(12)
                ->get(),
            'whyChooseUs' => SiteSetting::getJson('home_why_choose_us', $defaultWhyChooseUs),
            'aboutContent' => $aboutContent,
        ]);
    }
}
