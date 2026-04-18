<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/faqs', 'pages.faqs')->name('faqs');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/subscribe', [NewsletterController::class, 'store'])->name('subscribe.store');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/api/search', [ProductController::class, 'search'])->name('products.search');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.attempt');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/products/{product}/cart', [ProductController::class, 'addToCart'])->name('products.cart.store');
    Route::post('/products/{product}/wishlist', [ProductController::class, 'addToWishlist'])->name('products.wishlist.store');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('products.reviews.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}/cart', [WishlistController::class, 'moveToCart'])->name('wishlist.cart.store');
    Route::delete('/wishlist/{wishlistItem}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/razorpay/verify', [CheckoutController::class, 'verifyRazorpay'])->name('checkout.razorpay.verify');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/history/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/orders/track', [OrderController::class, 'trackForm'])->name('orders.track.form');
    Route::post('/orders/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{order}/thank-you', [OrderController::class, 'thankYou'])->name('orders.thankyou');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('categories/{category}/set-parent', [AdminCategoryController::class, 'setParent'])->name('categories.set-parent');
    Route::post('categories/{category}/make-main', [AdminCategoryController::class, 'makeMain'])->name('categories.make-main');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubcategoryController::class)->except('show');
    Route::resource('sliders', AdminSliderController::class)->except('show');
    Route::patch('reviews/{review}/toggle-status', [AdminReviewController::class, 'toggleStatus'])->name('reviews.toggle-status');
    Route::resource('reviews', AdminReviewController::class)->except('show');
    Route::get('content', [AdminContentController::class, 'edit'])->name('content.edit');
    Route::put('content', [AdminContentController::class, 'update'])->name('content.update');
    Route::resource('contact-messages', AdminContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::post('contact-messages/{contactMessage}/mark-read', [AdminContactMessageController::class, 'markRead'])->name('contact-messages.mark-read');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::resource('users', AdminUserController::class)->except(['create', 'store']);
});
