<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
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

    public function test_checkout_finalizes_razorpay_payment_and_shows_invoice(): void
    {
        Http::fake([
            'api.razorpay.com/v1/orders' => Http::response(['id' => 'order_test_123'], 200),
        ]);

        config([
            'services.razorpay.key_id' => 'rzp_test_ks9zLlM1eAiV1S',
            'services.razorpay.key_secret' => 'Wl63rHSkHOK2o4s7djULBKGx',
        ]);

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
            'stock' => 2,
        ]);

        CartItem::query()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'size' => 'M',
        ]);

        $checkoutResponse = $this->actingAs($user)->post(route('checkout.store'), [
            'first_name' => 'Asha',
            'last_name' => 'Verma',
            'address' => '123 Street',
            'city' => 'Mumbai',
            'zip' => '400001',
            'phone' => '9999999999',
            'email' => 'asha@example.com',
        ]);

        $checkoutResponse->assertOk();
        $checkoutResponse->assertViewIs('checkout.payment');
        $checkoutResponse->assertSee('Complete your Razorpay payment');
        $checkoutResponse->assertSee('order_test_123');
        $checkoutResponse->assertSessionHas('checkout.razorpay.razorpay_order_id', 'order_test_123');

        $paymentId = 'pay_test_123';
        $signature = hash_hmac('sha256', 'order_test_123|' . $paymentId, 'Wl63rHSkHOK2o4s7djULBKGx');

        $verifyResponse = $this->actingAs($user)->post(route('checkout.razorpay.verify'), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => 'order_test_123',
            'razorpay_signature' => $signature,
        ]);

        $verifyResponse->assertRedirect();

        $order = Order::query()->first();
        $this->assertNotNull($order);
        $this->assertSame('razorpay', $order->payment_method);
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('order_test_123', $order->razorpay_order_id);
        $this->assertSame($paymentId, $order->razorpay_payment_id);
        $this->assertNotNull($order->invoice_number);
        $this->assertDatabaseCount('cart_items', 0);

        $this->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee((string) $order->invoice_number)
            ->assertSee('Razorpay');
    }

    public function test_checkout_fails_when_stock_changes_before_payment_verification(): void
    {
        Http::fake([
            'api.razorpay.com/v1/orders' => Http::response(['id' => 'order_test_456'], 200),
        ]);

        config([
            'services.razorpay.key_id' => 'rzp_test_ks9zLlM1eAiV1S',
            'services.razorpay.key_secret' => 'Wl63rHSkHOK2o4s7djULBKGx',
        ]);

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

        $this->actingAs($user)->post(route('checkout.store'), [
            'first_name' => 'Asha',
            'last_name' => 'Verma',
            'address' => '123 Street',
            'city' => 'Mumbai',
            'zip' => '400001',
            'phone' => '9999999999',
            'email' => 'asha@example.com',
        ]);

        $product->update(['stock' => 0]);

        $paymentId = 'pay_test_456';
        $signature = hash_hmac('sha256', 'order_test_456|' . $paymentId, 'Wl63rHSkHOK2o4s7djULBKGx');

        $verifyResponse = $this->actingAs($user)->post(route('checkout.razorpay.verify'), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => 'order_test_456',
            'razorpay_signature' => $signature,
        ]);

        $verifyResponse->assertSessionHasErrors('cart');
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('cart_items', 1);
    }
}
