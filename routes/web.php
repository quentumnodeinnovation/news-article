<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaVideoController;
use App\Http\Controllers\CRM\EnquiryController;
use App\Http\Controllers\SitemapController;

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'newHome'])->name('home');

Route::get('/contact-us', function () {
    return view('contact.index');
})->name('contact.index');

Route::post('newsletter/subscribe', [HomeController::class, 'newsletterSubscribe'])->name('newsletter.subscribe');

Route::get('/articles', [HomeController::class, 'newsIndex'])->name('news.index');
Route::get('/articles/{slug}', [HomeController::class, 'newsDetailSlug'])->name('news.show');

Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/tag/{slug}', [HomeController::class, 'tag'])->name('tag.show');

Route::get('/plans', [SubscriptionController::class, 'index'])->name('frontend.plans.index');

Route::get('/plans/{slug}/subscribe', [SubscriptionController::class, 'showSubscribe'])->name('plans.subscribe.show');
Route::post('/plans/{slug}/subscribe', [SubscriptionController::class, 'subscribe'])->name('plans.subscribe');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('users/bulk-delete', [App\Http\Controllers\UserController::class, 'bulkDelete'])->name('users.bulkDelete');
Route::resource('users', UserController::class);

Route::resource('videos', DaVideoController::class);

Route::post('/contact-us/send', [EnquiryController::class, 'store'])->name('contact.send');

require __DIR__ . '/auth.php';
require __DIR__ . '/backend.php';
