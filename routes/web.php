<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\TeamController;

// Halaman Beranda
Route::get('/', function () {
    return view('welcome');
});

// Halaman Tentang Kami
Route::get('/tentang-kami', [TeamController::class, 'getTeamMembers']);

// Halaman Kontak
Route::get('/kontak', function () {
    // Ambil data kontak dari database jika ada
    $contact = \App\Models\Content::where('type', 'contact')
        ->where('status', 'published')
        ->first();

    return view('contact', compact('contact'));
});

// Form Kontak
Route::post('/kontak/submit', [\App\Http\Controllers\ContactFormController::class, 'submit'])->name('contact.submit');

// Halaman Produk
Route::get('/produk', [ContentController::class, 'getPublishedProducts']);

// Halaman Insight dan Artikel
Route::get('/insight', [ContentController::class, 'getPublishedArticles']);
Route::get('/insight/{slug}', [ContentController::class, 'showArticle']);
Route::get('/news-portal', [ContentController::class, 'getNewsPortal']);

// Admin Routes
Route::prefix('admin')->group(function () {
    // Slideshow Management
    Route::get('/slides', [SlideController::class, 'index'])->name('admin.slides.index');
    Route::post('/slides/update', [SlideController::class, 'update'])->name('admin.slides.update');

    // Product Management
    Route::get('/products', [ContentController::class, 'index'])->name('admin.products.index');
    Route::get('/products/archived', [ContentController::class, 'archived'])->name('admin.products.archived');
    Route::get('/products/create', [ContentController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ContentController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ContentController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ContentController::class, 'update'])->name('admin.products.update');
    Route::put('/products/{product}/retire', [ContentController::class, 'retire'])->name('admin.products.retire');
    Route::delete('/products/{product}', [ContentController::class, 'destroy'])->name('admin.products.destroy');

    // Vision Mission Management
    Route::get('/vision-mission', [ContentController::class, 'visiMisiIndex'])->name('admin.vision-mission.index');
    Route::post('/vision-mission/update', [ContentController::class, 'visiMisiUpdate'])->name('admin.vision-mission.update');

    // Contact Management
    Route::get('/contact', [ContentController::class, 'contactIndex'])->name('admin.contact.index');
    Route::post('/contact/update', [ContentController::class, 'contactUpdate'])->name('admin.contact.update');

    // Contact Messages Management
    Route::get('/contact-messages', [\App\Http\Controllers\ContactMessageController::class, 'index'])->name('admin.contact-messages.index');
    Route::get('/contact-messages/{message}', [\App\Http\Controllers\ContactMessageController::class, 'show'])->name('admin.contact-messages.show');
    Route::delete('/contact-messages/{message}', [\App\Http\Controllers\ContactMessageController::class, 'destroy'])->name('admin.contact-messages.destroy');
    Route::put('/contact-messages/{message}/mark-as-read', [\App\Http\Controllers\ContactMessageController::class, 'markAsRead'])->name('admin.contact-messages.mark-as-read');
    Route::put('/contact-messages/{message}/mark-as-unread', [\App\Http\Controllers\ContactMessageController::class, 'markAsUnread'])->name('admin.contact-messages.mark-as-unread');

    // Team Management
    Route::get('/team', [TeamController::class, 'index'])->name('admin.team.index');
    Route::get('/team/create', [TeamController::class, 'create'])->name('admin.team.create');
    Route::post('/team', [TeamController::class, 'store'])->name('admin.team.store');
    Route::get('/team/{team}/edit', [TeamController::class, 'edit'])->name('admin.team.edit');
    Route::put('/team/{team}', [TeamController::class, 'update'])->name('admin.team.update');
    Route::delete('/team/{team}', [TeamController::class, 'destroy'])->name('admin.team.destroy');
    Route::post('/team/update-order', [TeamController::class, 'updateOrder'])->name('admin.team.update-order');
});

// Blog/Article Management
Route::get('/articles', [ContentController::class, 'articlesIndex'])->name('admin.articles.index');
Route::get('/articles/archived', [ContentController::class, 'articlesArchived'])->name('admin.articles.archived');
Route::get('/articles/create', [ContentController::class, 'articlesCreate'])->name('admin.articles.create');
Route::post('/articles', [ContentController::class, 'articlesStore'])->name('admin.articles.store');
Route::get('/articles/{article}/edit', [ContentController::class, 'articlesEdit'])->name('admin.articles.edit');
Route::put('/articles/{article}', [ContentController::class, 'articlesUpdate'])->name('admin.articles.update');
Route::put('/articles/{article}/retire', [ContentController::class, 'articlesRetire'])->name('admin.articles.retire');
