<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\HistoryController;

// Halaman Beranda
Route::get('/', function () {
    $products = \App\Models\Content::where('type', 'product')
        ->where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->take(3)
        ->get();
    $insight_popular = \App\Models\Content::where('type', 'article')
        ->where('status', 'published')
        ->orderBy('views', 'desc')
        ->first();
    $insight_latest = \App\Models\Content::where('type', 'article')
        ->where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->take(2)
        ->get();
    $partner_logos = \App\Models\Content::where('type', 'portfolio')
        ->where('status', 'published')
        ->whereNotNull('partner_logo')
        ->pluck('partner_logo');
    return view('welcome', compact('products', 'insight_popular', 'insight_latest', 'partner_logos'));
});

// Halaman Tentang Kami
Route::get('/tentang-kami', [ContentController::class, 'getVisiMisi'])->name('about');

// Halaman Kontak
Route::get('/kontak', function () {
    // Ambil data kontak dari database jika ada
    $contact = \App\Models\Content::where('type', 'contact')
        ->where('status', 'published')
        ->first();

    return view('contact', compact('contact'));
})->name('contact');

// Form Kontak
Route::post('/kontak/submit', [\App\Http\Controllers\ContactFormController::class, 'submit'])->name('contact.submit');

// Halaman Produk
Route::get('/produk', [ContentController::class, 'getPublishedProducts'])->name('products');
Route::get('/produk/{slug}', [ContentController::class, 'getProductDetail'])->name('products.show');

// Halaman Insight dan Artikel
Route::get('/insight', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insight/{slug}', [InsightController::class, 'show'])->name('insights.show');
Route::get('/news-portal', [ContentController::class, 'getNewsPortal']);

// Halaman Portfolio
Route::get('/portfolio', [ContentController::class, 'getPublishedPortfolios'])->name('portfolio');
Route::get('/portfolio/{slug}', [ContentController::class, 'getPortfolioDetail'])->name('portfolio.show');

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

    // History Management
    Route::get('/history', [HistoryController::class, 'index'])->name('admin.history.index');
    Route::get('/history/create', [HistoryController::class, 'create'])->name('admin.history.create');
    Route::post('/history', [HistoryController::class, 'store'])->name('admin.history.store');
    Route::get('/history/{history}/edit', [HistoryController::class, 'edit'])->name('admin.history.edit');
    Route::put('/history/{history}', [HistoryController::class, 'update'])->name('admin.history.update');
    Route::delete('/history/{history}', [HistoryController::class, 'destroy'])->name('admin.history.destroy');

    // Blog/Article Management
    Route::get('/articles', [ContentController::class, 'articlesIndex'])->name('admin.articles.index');
    Route::get('/articles/archived', [ContentController::class, 'articlesArchived'])->name('admin.articles.archived');
    Route::get('/articles/create', [ContentController::class, 'articlesCreate'])->name('admin.articles.create');
    Route::post('/articles', [ContentController::class, 'articlesStore'])->name('admin.articles.store');
    Route::get('/articles/{article}/edit', [ContentController::class, 'articlesEdit'])->name('admin.articles.edit');
    Route::put('/articles/{article}', [ContentController::class, 'articlesUpdate'])->name('admin.articles.update');
    Route::put('/articles/{article}/retire', [ContentController::class, 'articlesRetire'])->name('admin.articles.retire');

    // Portfolio Management
    Route::get('/portfolios', [ContentController::class, 'portfoliosIndex'])->name('admin.portfolios.index');
    Route::get('/portfolios/archived', [ContentController::class, 'portfoliosArchived'])->name('admin.portfolios.archived');
    Route::get('/portfolios/create', [ContentController::class, 'portfoliosCreate'])->name('admin.portfolios.create');
    Route::post('/portfolios', [ContentController::class, 'portfoliosStore'])->name('admin.portfolios.store');
    Route::get('/portfolios/{portfolio}/edit', [ContentController::class, 'portfoliosEdit'])->name('admin.portfolios.edit');
    Route::put('/portfolios/{portfolio}', [ContentController::class, 'portfoliosUpdate'])->name('admin.portfolios.update');
    Route::put('/portfolios/{portfolio}/retire', [ContentController::class, 'portfoliosRetire'])->name('admin.portfolios.retire');
});
