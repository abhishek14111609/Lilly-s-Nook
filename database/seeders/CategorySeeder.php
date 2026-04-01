<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Child' => ['1 Year', '2 Year', '3 Year', '4 Year', '5 Year'],
            'Men' => ['Pants', 'Shoes', 'T-Shirts', 'Accessories'],
            'Women' => ['Dresses', 'Handbags', 'Jewelry', 'Pants'],
        ];

        foreach ($categories as $parent => $subs) {
            $parentCat = Category::create([
                'name' => $parent,
                'slug' => Str::slug($parent),
                'description' => "Shop all products for {$parent}",
            ]);

            foreach ($subs as $sub) {
                Category::create([
                    'name' => $sub,
                    'slug' => Str::slug($sub) . '-' . Str::slug($parent),
                    'parent_id' => $parentCat->id,
                    'description' => "Selected {$sub} for {$parent}",
                ]);
            }
        }
    }
}
