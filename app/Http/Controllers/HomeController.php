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
        $defaultAgeGroups = [
            '2-3 years',
            '3-4 years',
            '4-5 years',
            '5-6 years',
            '6-7 years',
        ];

        $defaultCollections = [
            'Whimsical New Arrivals',
            'Bestselling Classics',
            'Occasion Dresses with a Vintage Twist',
        ];

        $defaultWhyChooseUs = [
            [
                'title' => 'Handpicked designs that spark joy',
                'description' => 'Curated pieces that celebrate wonder, playfulness, and personality.',
                'icon' => 'icon icon-check-circle',
            ],
            [
                'title' => 'Timeless elegance with a whimsical twist',
                'description' => 'Vintage-inspired silhouettes made for modern little trendsetters.',
                'icon' => 'icon icon-star',
            ],
            [
                'title' => 'Quality craftsmanship for little treasures',
                'description' => 'Soft fabrics and thoughtful finishing built for comfort and durability.',
                'icon' => 'icon icon-user',
            ],
            [
                'title' => 'Curated with love, for the little ones',
                'description' => 'Every collection is selected to keep childhood style magical and effortless.',
                'icon' => 'icon icon-heart',
            ],
        ];

        $aboutContent = [
            'kicker' => SiteSetting::getValue('home_about_kicker', "Welcome to Lilly's Nook"),
            'title' => SiteSetting::getValue('home_about_title', "Where yesterday's charm meets today's little star"),
            'description' => SiteSetting::getValue('home_about_description', "Inspired by whispers of the past, Lilly's Nook curates enchanting outfits that spark wonder in the hearts of curious, stylish girls."),
            'story_title' => SiteSetting::getValue('home_story_title', 'Our Story'),
            'collections_title' => SiteSetting::getValue('home_collections_title', 'Shop Our Timeless Collections'),
            'collections_items' => SiteSetting::getJson('home_collections_items', $defaultCollections),
        ];

        return view('home', [
            'sliders' => HomeSlider::query()->where('is_active', '=', true)->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get(),
            'featuredProducts' => Product::query()->latest('id')->take(8)->get(),
            'latestProducts' => Product::query()->latest('id')->take(4)->get(),
            'categories' => Category::query()
                ->whereNull('parent_id', 'and', false)
                ->with(['children' => fn($q) => $q->withCount('products')->orderBy('name', 'asc')])
                ->withCount('products')
                ->orderBy('name', 'asc')
                ->take(6)
                ->get(),
            'testimonials' => Review::query()
                ->whereNull('product_id', 'and', false)
                ->where('is_active', '=', true)
                ->whereNotNull('quote', 'and')
                ->orderBy('sort_order', 'asc')
                ->orderBy('id', 'desc')
                ->take(12)
                ->get(),
            'homeIntroText' => SiteSetting::getValue('home_intro_text', "Step into the enchanting world of Lily's Nook, where delicate lace, soft pastels, and timeless silhouettes come together in a celebration of childhood whimsy. Our carefully crafted collections evoke the elegance of a bygone era, with a playful twist that perfectly captures the spirit of little girls who light up the world."),
            'homeAgeGroups' => SiteSetting::getJson('home_age_groups', $defaultAgeGroups),
            'whyChooseUs' => SiteSetting::getJson('home_why_choose_us', $defaultWhyChooseUs),
            'aboutContent' => $aboutContent,
        ]);
    }
}
