<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@ultras.test',
                'password' => 'Admin@123',
                'is_admin' => true,
            ]
        );

        User::query()->updateOrCreate(
            ['username' => 'customer'],
            [
                'name' => 'Customer',
                'email' => 'customer@ultras.test',
                'password' => 'Customer@123',
                'is_admin' => false,
            ]
        );

        // Seed categories
        $categories = [
            ['name' => 'Tshirts', 'slug' => 'tshirts'],
            ['name' => 'Pants', 'slug' => 'pants'],
            ['name' => 'Hoodie', 'slug' => 'hoodie'],
            ['name' => 'Jackets', 'slug' => 'jackets'],
            ['name' => 'Outer', 'slug' => 'outer'],
            ['name' => 'Shoes', 'slug' => 'shoes'],
        ];
        $categoryMap = [];
        foreach ($categories as $cat) {
            $category = \App\Models\Category::firstOrCreate(['slug' => $cat['slug']], $cat);
            $categoryMap[$cat['name']] = $category->id;
        }

        $products = [
            ['name' => 'Full Sleeve Cover Shirt', 'price' => 200.00, 'image' => 'product-item1.jpg', 'category' => 'Tshirts', 'description' => 'A casual full sleeve shirt built for daily wear.'],
            ['name' => 'Volunteer Half blue', 'price' => 388.00, 'image' => 'product-item2.jpg', 'category' => 'Tshirts', 'description' => 'Soft half sleeve tee in a clean blue finish.'],
            ['name' => 'Double yellow shirt', 'price' => 440.00, 'image' => 'product-item3.jpg', 'category' => 'Tshirts', 'description' => 'Bright double-tone shirt for standout casual looks.'],
            ['name' => 'Long belly grey pant', 'price' => 330.00, 'image' => 'product-item4.jpg', 'category' => 'Pants', 'description' => 'Relaxed grey pants designed for everyday comfort.'],
            ['name' => 'Half sleeve T-shirt', 'price' => 200.00, 'image' => 'selling-products1.jpg', 'category' => 'Tshirts', 'description' => 'Essential half sleeve tee with a lightweight feel.'],
            ['name' => 'Stylish Grey T-shirt', 'price' => 355.00, 'image' => 'selling-products2.jpg', 'category' => 'Tshirts', 'description' => 'Minimal grey t-shirt with a sharp, modern fit.'],
            ['name' => 'Silk White Shirt', 'price' => 355.00, 'image' => 'selling-products3.jpg', 'category' => 'Tshirts', 'description' => 'Smooth white shirt for dressed-up casual styling.'],
            ['name' => 'Grunge Hoodie', 'price' => 455.00, 'image' => 'selling-products4.jpg', 'category' => 'Hoodie', 'description' => 'Heavyweight hoodie with a streetwear-inspired finish.'],
            ['name' => 'Full sleeve Jeans jacket', 'price' => 409.00, 'image' => 'selling-products5.jpg', 'category' => 'Jackets', 'description' => 'Classic denim jacket with an easy layering fit.'],
            ['name' => 'Grey Check Coat', 'price' => 352.00, 'image' => 'selling-products6.jpg', 'category' => 'Outer', 'description' => 'Checked outerwear piece that sharpens cold-weather looks.'],
            ['name' => 'Long Sleeve T-shirt', 'price' => 400.00, 'image' => 'selling-products7.jpg', 'category' => 'Tshirts', 'description' => 'Clean long sleeve tee that works across seasons.'],
            ['name' => 'Half Sleeve T-shirt', 'price' => 200.00, 'image' => 'selling-products8.jpg', 'category' => 'Tshirts', 'description' => 'A simple half sleeve staple with a relaxed silhouette.'],
            ['name' => 'Orange white Nike', 'price' => 555.00, 'image' => 'selling-products13.jpg', 'category' => 'Shoes', 'description' => 'Sport-inspired sneaker with a bold orange-white palette.'],
            ['name' => 'Running Shoe', 'price' => 300.00, 'image' => 'selling-products14.jpg', 'category' => 'Shoes', 'description' => 'Light running shoe for active days and casual wear.'],
            ['name' => 'Tennis Shoe', 'price' => 800.00, 'image' => 'selling-products15.jpg', 'category' => 'Shoes', 'description' => 'Premium tennis shoe with cushioned comfort and grip.'],
            ['name' => 'Nike Brand Shoe', 'price' => 550.00, 'image' => 'selling-products16.jpg', 'category' => 'Shoes', 'description' => 'Versatile sneaker with a clean branded finish.'],
        ];

        foreach ($products as $product) {
            $category_id = $categoryMap[$product['category']] ?? null;
            Product::query()->updateOrCreate(
                ['name' => $product['name']],
                [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'description' => $product['description'],
                    'category_id' => $category_id,
                ]
            );
        }
    }
}
