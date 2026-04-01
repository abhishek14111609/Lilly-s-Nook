<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminUploadsAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_slider_image(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.sliders.store'), [
            'title' => 'Hero Slide',
            'subtitle' => 'Dynamic hero subtitle',
            'button_text' => 'Shop',
            'button_url' => route('shop.index'),
            'sort_order' => 1,
            'is_active' => 1,
            'image_file' => UploadedFile::fake()->image('hero.jpg'),
        ]);

        $response->assertRedirect(route('admin.sliders.index'));

        $slider = HomeSlider::query()->first();
        $this->assertNotNull($slider);
        $this->assertStringStartsWith('uploads/sliders/', $slider->image);
        $this->assertTrue(is_file(public_path('images/' . $slider->image)));
    }

    public function test_admin_can_upload_category_image(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Women',
            'description' => 'Main women collection',
            'image_file' => UploadedFile::fake()->image('women.jpg'),
        ]);

        $response->assertRedirect(route('admin.categories.index'));

        $category = Category::query()->where('name', 'Women')->first();
        $this->assertNotNull($category);
        $this->assertStringStartsWith('uploads/categories/', (string) $category->image);
        $this->assertTrue(is_file(public_path('images/' . $category->image)));
    }

    public function test_admin_can_upload_product_image(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::query()->create([
            'name' => 'Tops',
            'slug' => 'tops',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Rose Shirt',
            'description' => 'Soft cotton shirt',
            'price' => 499,
            'stock' => 10,
            'category_id' => $category->id,
            'image_file' => UploadedFile::fake()->image('shirt.jpg'),
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::query()->where('name', 'Rose Shirt')->first();
        $this->assertNotNull($product);
        $this->assertStringStartsWith('uploads/products/', $product->image);
        $this->assertTrue(is_file(public_path('images/' . $product->image)));
    }

    public function test_checkout_fails_when_stock_changes_before_order(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $category = Category::query()->create([
            'name' => 'Dresses',
            'slug' => 'dresses',
        ]);

        $product = Product::query()->create([
            'name' => 'Floral Dress',
            'description' => 'Elegant floral dress',
            'price' => 799,
            'image' => 'product-item1.jpg',
            'category_id' => $category->id,
            'stock' => 1,
        ]);

        CartItem::query()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'size' => 'M',
        ]);

        $product->update(['stock' => 0]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'first_name' => 'Asha',
            'last_name' => 'Verma',
            'address' => '123 Street',
            'city' => 'Mumbai',
            'zip' => '400001',
            'phone' => '9999999999',
            'email' => 'asha@example.com',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHasErrors('cart');
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'size' => 'M',
        ]);
    }
}