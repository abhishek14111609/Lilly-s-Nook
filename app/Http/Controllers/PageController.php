<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;

class PageController extends Controller
{
    public function about()
    {
        $defaultPromiseItems = [
            "Style that's as unique as your little one",
            'Care for the planet, with every stitch',
            'Joy in every outfit, because childhood is magic',
        ];

        return view('pages.about', [
            'aboutTitle' => SiteSetting::getValue('about_title', "About Lily's Nook"),
            'aboutBodyOne' => SiteSetting::getValue('about_body_one', "Lily's Nook is a celebration of childhood's magic, crafted with love for little ones who shine bright."),
            'aboutBodyTwo' => SiteSetting::getValue('about_body_two', "We curate timeless, whimsical outfits that spark imagination and wonder. With a focus on sustainable style and quality craftsmanship, we're here to make dressing dreams effortless for you and enchanting for them."),
            'aboutPromiseTitle' => SiteSetting::getValue('about_promise_title', 'Our Promise'),
            'aboutPromiseItems' => SiteSetting::getJson('about_promise_items', $defaultPromiseItems),
            'aboutImage' => SiteSetting::getValue('about_image', 'collection-item1.jpg'),
        ]);
    }
}
