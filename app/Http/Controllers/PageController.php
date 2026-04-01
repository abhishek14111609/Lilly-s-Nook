<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'aboutTitle' => SiteSetting::getValue('about_title', 'Established in 2024'),
            'aboutBodyOne' => SiteSetting::getValue('about_body_one', "Lilly's Nook was created to provide high-quality boutique clothing with a focus on ease and personalized service. Our mission is to combine the best of modern fashion with a seamless online experience."),
            'aboutBodyTwo' => SiteSetting::getValue('about_body_two', "Our platform features secure customer accounts, persistent carts, wishlists, and a streamlined checkout process to ensure you find exactly what you're looking for."),
            'aboutImage' => SiteSetting::getValue('about_image', 'collection-item1.jpg'),
        ]);
    }
}
