<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientCollectionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset only catalog data requested by client.
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('product_variants')->truncate();
        DB::table('cart_items')->truncate();
        DB::table('wishlist_items')->truncate();
        DB::table('products')->truncate();
        DB::table('subcategories')->truncate();
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $partyWear = Category::create([
            'name' => 'Fancy / Party Wear',
            'slug' => Str::slug('Fancy / Party Wear'),
            'description' => 'Occasion and party dresses for kids.',
        ]);

        $sustainable = Category::create([
            'name' => 'Cotton / Lace (Sustainable Collection)',
            'slug' => Str::slug('Cotton / Lace Sustainable Collection'),
            'description' => 'Sustainable cotton-focused everyday collection.',
        ]);

        $partySubcats = [
            'Sparkle Stories' => Subcategory::create([
                'category_id' => $partyWear->id,
                'name' => 'Sparkle Stories',
                'slug' => Str::slug('Sparkle Stories'),
                'description' => 'Shimmer and sparkle-led statement pieces.',
            ]),
            'Chic & Cherished' => Subcategory::create([
                'category_id' => $partyWear->id,
                'name' => 'Chic & Cherished',
                'slug' => Str::slug('Chic & Cherished'),
                'description' => 'Elegant premium occasion styles.',
            ]),
            'Party Princess' => Subcategory::create([
                'category_id' => $partyWear->id,
                'name' => 'Party Princess',
                'slug' => Str::slug('Party Princess'),
                'description' => 'Classic party-ready girls dresses.',
            ]),
            'Dazzle & Dream' => Subcategory::create([
                'category_id' => $partyWear->id,
                'name' => 'Dazzle & Dream',
                'slug' => Str::slug('Dazzle & Dream'),
                'description' => 'Decorative dreamy silhouettes.',
            ]),
        ];

        $sustainableSubcats = [
            'Everyday Elegance' => Subcategory::create([
                'category_id' => $sustainable->id,
                'name' => 'Everyday Elegance',
                'slug' => Str::slug('Everyday Elegance'),
                'description' => 'Lightweight cotton looks for daily wear.',
            ]),
            'Cotton Comforts' => Subcategory::create([
                'category_id' => $sustainable->id,
                'name' => 'Cotton Comforts',
                'slug' => Str::slug('Cotton Comforts'),
                'description' => 'Soft breathable cotton with comfort fits.',
            ]),
            'Comfort Couture' => Subcategory::create([
                'category_id' => $sustainable->id,
                'name' => 'Comfort Couture',
                'slug' => Str::slug('Comfort Couture'),
                'description' => 'Craft-forward cotton styles.',
            ]),
        ];

        $imagePlaceholder = 'uploads/products/placeholder.jpg';

        $this->createProduct(
            'DSC00016 - Pink Bow Dress',
            'Age 5-6 years. 100% viscose chimney fabric. Strap style with hand-embroidered front bow, smoking at back part with belt. Chest 32 cm relaxed, back stretched 39 cm, length 60 cm.',
            2599,
            8,
            $partyWear,
            $partySubcats['Party Princess'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC03157 - Fuchsia Flower Net Dress',
            'Age 3-4 years. Fuchsia, soft pink and snowy white tones. Viscose net with all-over sequin work and fabric flowers, antique gold bead work. Chest 35 cm, length 65 cm.',
            2799,
            8,
            $partyWear,
            $partySubcats['Dazzle & Dream'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00035 - Floral Cotton Embroidery Dress',
            'Age 5-6 years. 100% cotton floral embroidery. Dress with belt. Chest 34 cm, length 65 cm.',
            2299,
            10,
            $sustainable,
            $sustainableSubcats['Comfort Couture'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00034 - White Netted Flared Dress',
            'Age 5-6 years. 100% viscose netted flared dress with handmade flowers and antique gold glittered net. No belt. Chest 36 cm, length 67 cm.',
            2899,
            7,
            $partyWear,
            $partySubcats['Sparkle Stories'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00053 - Butterfly Embroidery Cotton Dress',
            'Age 3-4 years. 100% cotton, multicolor butterfly embroidery. Dress with belt. Chest 31 cm, length 62 cm.',
            2199,
            10,
            $sustainable,
            $sustainableSubcats['Everyday Elegance'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Heart Embroidery Cotton Dress',
            'Age 3-4 years. 100% cotton with little red hearts embroidery all over and thread embroidery at bottom. Loose fit chest 34 cm, length 57 cm.',
            2099,
            10,
            $sustainable,
            $sustainableSubcats['Cotton Comforts'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00032 - Sea Green Sequin Dress',
            'Age 2-3 years. 100% viscose. Antique gold sequin hand embroidery on front decorated with bow. Chest 31 cm, length 50 cm.',
            2699,
            8,
            $partyWear,
            $partySubcats['Sparkle Stories'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Floral Thread Cotton Dress',
            'Age 4-5 years. 100% cotton with multicolor floral embroidery. Dress with belt. Chest 33 cm, length 58 cm.',
            2299,
            9,
            $sustainable,
            $sustainableSubcats['Comfort Couture'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00024 - Silk Chanderi Dress',
            'Age 5-6 years. 100% silk chanderi natural tone with golden floral embossed design. Dress with belt. Chest 34 cm, length 66 cm.',
            2999,
            7,
            $partyWear,
            $partySubcats['Chic & Cherished'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Multistriped Shimmery Dress',
            'Age 2-3 years. 100% viscose shimmery fabric with multistripes. Front bow with belt, short dress. Length 45 cm, chest 30 cm.',
            2499,
            9,
            $partyWear,
            $partySubcats['Party Princess'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Red Chimney Party Dress',
            'Age 2-3 years. 100% viscose chimney fabric. Front hand embroidery with antique gold beads. Dress with belt. Chest 30 cm, length 50 cm.',
            2799,
            8,
            $partyWear,
            $partySubcats['Party Princess'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Yellow Green Polka Cotton Dress',
            'Age 2-3 years. 100% cotton, yellow and green polka dots. Pompom dori at front. Chest 29 cm, length 52 cm.',
            1999,
            10,
            $sustainable,
            $sustainableSubcats['Everyday Elegance'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Smocking Embroidered Strap Dress',
            'Age 5-6 years. 100% viscose all-over embroidered dress with smocking at front. Chest 40 cm stretched and 27 cm relaxed. Adjustable length 74 cm.',
            2599,
            8,
            $partyWear,
            $partySubcats['Chic & Cherished'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Yellow Hand-Decorated Net Dress',
            'Age 2-3 years. 100% viscose net with hand-decorated fabric flowers and belt. Length 52 cm adjustable, chest 30 cm, elastic at back.',
            2699,
            8,
            $partyWear,
            $partySubcats['Dazzle & Dream'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00055 - Lurex Cotton Long Dress',
            'Age 3-4 years. 100% cotton long dress with blue-pink lurex detailing and side belts. Chest 32 cm, length 67 cm.',
            2399,
            9,
            $sustainable,
            $sustainableSubcats['Comfort Couture'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00070 - Smocking Cotton Dress',
            'Age 5-6 years. 100% cotton with embroidery at smocking part. Relaxed smocking 27 cm, stretched smocking 40 cm. Length 75 cm.',
            2299,
            9,
            $sustainable,
            $sustainableSubcats['Cotton Comforts'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Royal Blue Shimmery Dress',
            'Age 2-3 years. Royal blue shimmery fabric, 100% viscose. Hand-embroidered bow at front with belt. Chest 31 cm, length 52 cm.',
            2599,
            8,
            $partyWear,
            $partySubcats['Sparkle Stories'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00080 - Blue Hearts Cotton Dress',
            'Age 2-3 years. 100% cotton short dress with little heart embroidery and chimney bow at front. Chest 33 cm, length 46 cm.',
            2099,
            10,
            $sustainable,
            $sustainableSubcats['Everyday Elegance'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC03138 - Tie-Dye Gold Embroidered Net Dress',
            'Age 3-4 years. 100% viscose gold-embroidered net, tie-dye colored, with belt. Chest 31 cm, length 54 cm.',
            2699,
            8,
            $partyWear,
            $partySubcats['Dazzle & Dream'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00077 - Fuchsia Poplin Cotton Dress',
            'Age 3-4 years. 100% fuchsia poplin cotton with floral machine embroidery. Pom pom lace at sleeves and bottom, neck decorated with sequins and beads. Chest 31 cm, length 48 cm.',
            2299,
            9,
            $sustainable,
            $sustainableSubcats['Comfort Couture'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00075 - Multicolored Shimmery Dress',
            'Age 3-4 years. 100% viscose shimmery multicolored fabric with beautiful back bow. Chest 34 cm, length 56 cm.',
            2599,
            8,
            $partyWear,
            $partySubcats['Chic & Cherished'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00061 - Organza Embroidered Dress',
            'Age 5-6 years. 100% viscose organza with all-over floral embroidery and hand bead work. Chest 36 cm, length 71 cm.',
            2899,
            7,
            $partyWear,
            $partySubcats['Chic & Cherished'],
            $imagePlaceholder
        );

        $this->createProduct(
            'Blue Check Hearts Cotton Dress',
            'Age 6-7 years. 100% cotton check fabric with little heart embroidery all over. Smocked chest 40 cm relaxed. Length 67 cm.',
            2399,
            9,
            $sustainable,
            $sustainableSubcats['Cotton Comforts'],
            $imagePlaceholder
        );

        $this->createProduct(
            'DSC00064 - Crinkled Shimmer Bow Dress',
            'Age 6-7 years. 100% viscose crinkled shimmer fabric with hand-sequined bow at front and belt. Chest 38 cm, length 70 cm.',
            2799,
            8,
            $partyWear,
            $partySubcats['Sparkle Stories'],
            $imagePlaceholder
        );
    }

    private function createProduct(
        string $name,
        string $description,
        float $price,
        int $stock,
        Category $category,
        Subcategory $subcategory,
        string $image
    ): void {
        Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'stock' => $stock,
            'image' => $image,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
    }
}
