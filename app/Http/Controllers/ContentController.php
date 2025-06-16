<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Content;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\HistoryController;
use App\Models\Team;

class ContentController extends Controller
{
    /**
     * Menampilkan halaman kelola produk/layanan
     */
    public function index()
    {
        $products = Content::where('type', 'product')
            ->where('status', '!=', 'retired')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('back-end.products.index', compact('products'));
    }

    /**
     * Menampilkan halaman produk yang diarsipkan
     */
    public function archived()
    {
        $products = Content::where('type', 'product')
            ->where('status', 'retired')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('back-end.products.archived', compact('products'));
    }

    /**
     * Menampilkan form tambah produk
     */
    public function create()
    {
        return view('back-end.products.create');
    }

    /**
     * Menyimpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,retired'
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('products', 'public');
        }

        Content::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'type' => 'product',
            'status' => $request->status,
            'featured_image' => $imagePath,
            'meta_description' => $request->meta_description,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit produk
     */
    public function edit($id)
    {
        $product = Content::where('type', 'product')->findOrFail($id);
        return view('back-end.products.edit', compact('product'));
    }

    /**
     * Mengupdate produk
     */
    public function update(Request $request, $id)
    {
        $product = Content::where('type', 'product')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published'
        ]);

        $imagePath = $product->featured_image;
        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama jika ada
            if ($product->featured_image && Storage::exists('public/' . $product->featured_image)) {
                Storage::delete('public/' . $product->featured_image);
            }

            $imagePath = $request->file('featured_image')->store('products', 'public');
        }

        $product->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'featured_image' => $imagePath,
            'meta_description' => $request->meta_description,
            'published_at' => $request->status === 'published' ? ($product->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk
     */
    public function destroy($id)
    {
        $product = Content::where('type', 'product')->findOrFail($id);

        // Hapus gambar jika ada
        if ($product->featured_image && Storage::exists('public/' . $product->featured_image)) {
            Storage::delete('public/' . $product->featured_image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Mengarsipkan produk
     */
    public function retire($id)
    {
        $product = Content::where('type', 'product')->findOrFail($id);
        $product->update(['status' => 'retired']);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diarsipkan!');
    }

    /**
     * Mengambil data produk untuk halaman frontend
     */
    public function getPublishedProducts()
    {
        $products = Content::where('type', 'product')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        return view('products', compact('products'));
    }

    /**
     * Menampilkan detail produk di halaman frontend.
     */
    public function getProductDetail($slug)
    {
        $product = Content::where('type', 'product')
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $product->increment('views');

        // Ambil produk terkait (contoh: 3 produk terbaru kecuali produk saat ini)
        $relatedProducts = Content::where('type', 'product')
            ->where('status', 'published')
            ->where('id', '!=', $product->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }

    /**
     * Menampilkan halaman kelola visi misi
     */
    public function visiMisiIndex()
    {
        $visi = Content::where('type', 'visi')->first();
        $misi = Content::where('type', 'misi')->first();

        return view('back-end.vision-mission.index', compact('visi', 'misi'));
    }

    /**
     * Menyimpan atau memperbarui visi misi
     */
    public function visiMisiUpdate(Request $request)
    {
        $request->validate([
            'visi_content' => 'required|string',
            'misi_content' => 'required|string',
            'misi_points' => 'required|array',
            'misi_points.*' => 'required|string',
        ]);

        // Update atau buat visi
        $visi = Content::updateOrCreate(
            ['type' => 'visi'],
            [
                'title' => 'Visi Perusahaan',
                'slug' => 'visi-perusahaan',
                'content' => $request->visi_content,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        // Update atau buat misi
        $misiPoints = implode('|', $request->misi_points);
        $misi = Content::updateOrCreate(
            ['type' => 'misi'],
            [
                'title' => 'Misi Perusahaan',
                'slug' => 'misi-perusahaan',
                'content' => $request->misi_content,
                'meta_description' => $misiPoints, // Menyimpan poin-poin misi di meta_description
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        return redirect()->route('admin.vision-mission.index')
            ->with('success', 'Visi dan Misi berhasil diperbarui!');
    }

    /**
     * Mengambil data visi misi untuk halaman about
     */
    public function getVisiMisi()
    {
        $visi = Content::where('type', 'visi')->where('status', 'published')->first();
        $misi = Content::where('type', 'misi')->where('status', 'published')->first();
        $histories = \App\Models\History::orderBy('order')->get();
        $teamMembers = \App\Models\TeamMember::orderBy('order')->get();

        return view('about', compact('visi', 'misi', 'histories', 'teamMembers'));
    }

    /**
     * Menampilkan halaman kelola kontak
     */
    public function contactIndex()
    {
        $contact = Content::where('type', 'contact')->first();

        return view('back-end.contact.index', compact('contact'));
    }

    /**
     * Menyimpan atau memperbarui informasi kontak
     */
    public function contactUpdate(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'wa_number' => 'nullable|string',
            'map_url' => 'required|string',
        ]);

        // Update atau buat kontak
        $contact = Content::updateOrCreate(
            ['type' => 'contact'],
            [
                'title' => 'Informasi Kontak',
                'slug' => 'informasi-kontak',
                'content' => $request->address,
                'meta_description' => json_encode([
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'map_url' => $request->map_url,
                ]),
                'wa_number' => $request->wa_number,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        return redirect()->route('admin.contact.index')
            ->with('success', 'Informasi kontak berhasil diperbarui!');
    }

    // Blog/Article Management Methods
    public function articlesIndex()
    {
        $articles = Content::where('type', 'article')
            ->where('status', '!=', 'retired')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('back-end.articles.index', compact('articles'));
    }

    public function articlesArchived()
    {
        $articles = Content::where('type', 'article')
            ->where('status', 'retired')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('back-end.articles.archived', compact('articles'));
    }

    public function articlesCreate()
    {
        return view('back-end.articles.create');
    }

    public function articlesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,retired'
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        }

        Content::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'type' => 'article',
            'status' => $request->status,
            'featured_image' => $imagePath,
            'meta_description' => $request->meta_description,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function articlesEdit($id)
    {
        $article = Content::where('type', 'article')->findOrFail($id);
        return view('back-end.articles.edit', compact('article'));
    }

    public function articlesUpdate(Request $request, $id)
    {
        $article = Content::where('type', 'article')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,retired'
        ]);

        $imagePath = $article->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        }

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'featured_image' => $imagePath,
            'meta_description' => $request->meta_description,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function articlesRetire($id)
    {
        $article = Content::where('type', 'article')->findOrFail($id);

        $article->update([
            'status' => 'retired'
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diarsipkan!');
    }

    // Update method untuk halaman insight
    public function getPublishedArticles()
    {
        $articles = Content::where('type', 'article')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(8);

        return view('insights', compact('articles'));
    }

    /**
     * Menampilkan detail artikel/berita di halaman frontend.
     */
    public function showArticle($slug)
    {
        $article = Content::where('type', 'article')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views count
        $article->increment('views');

        // Ambil artikel terkait (contoh: 3 artikel terbaru dari kategori yang sama, kecuali artikel saat ini)
        $relatedArticles = Content::where('type', 'article')
            ->where('status', 'published')
            ->where('id', '!=', $article->id)
            // Jika ada category_id, uncomment dan sesuaikan
            // ->when($article->category_id, function ($query) use ($article) {
            //     return $query->where('category_id', $article->category_id);
            // })
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('article', compact('article', 'relatedArticles'));
    }

    /**
     * Menampilkan portal berita dengan tampilan list
     */

    // Portfolio Management Methods
    public function portfoliosIndex()
    {
        $portfolios = Content::where('type', 'portfolio')
            ->where('status', '!=', 'retired')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('back-end.portfolios.index', compact('portfolios'));
    }

    public function portfoliosArchived()
    {
        $portfolios = Content::where('type', 'portfolio')
            ->where('status', 'retired')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('back-end.portfolios.archived', compact('portfolios'));
    }

    public function portfoliosCreate()
    {
        return view('back-end.portfolios.create');
    }

    public function portfoliosStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'partner_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,retired'
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('portfolios', 'public');
        }

        $partnerLogoPath = null;
        if ($request->hasFile('partner_logo')) {
            $partnerLogoPath = $request->file('partner_logo')->store('partner-logos', 'public');
        }

        Content::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'type' => 'portfolio',
            'status' => $request->status,
            'featured_image' => $imagePath,
            'partner_logo' => $partnerLogoPath,
            'meta_description' => $request->meta_description,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function portfoliosEdit($id)
    {
        $portfolio = Content::where('type', 'portfolio')->findOrFail($id);
        return view('back-end.portfolios.edit', compact('portfolio'));
    }

    public function portfoliosUpdate(Request $request, $id)
    {
        $portfolio = Content::where('type', 'portfolio')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'partner_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,retired'
        ]);

        $imagePath = $portfolio->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('featured_image')->store('portfolios', 'public');
        }

        $partnerLogoPath = $portfolio->partner_logo;
        if ($request->hasFile('partner_logo')) {
            if ($partnerLogoPath) {
                Storage::disk('public')->delete($partnerLogoPath);
            }
            $partnerLogoPath = $request->file('partner_logo')->store('partner-logos', 'public');
        }

        $portfolio->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'featured_image' => $imagePath,
            'partner_logo' => $partnerLogoPath,
            'meta_description' => $request->meta_description,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui!');
    }

    public function portfoliosRetire($id)
    {
        $portfolio = Content::where('type', 'portfolio')->findOrFail($id);

        $portfolio->update([
            'status' => 'retired'
        ]);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diarsipkan!');
    }

    public function getPublishedPortfolios()
    {
        $portfolios = Content::where('type', 'portfolio')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(8); // Or a different number as needed

        return view('portfolios', compact('portfolios')); // Assumes a portfolios.blade.php view
    }

    public function getPortfolioDetail($slug)
    {
        $portfolio = Content::where('type', 'portfolio')
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $portfolio->increment('views');

        // Get related portfolios (3 latest portfolios excluding current portfolio)
        $relatedPortfolios = Content::where('type', 'portfolio')
            ->where('status', 'published')
            ->where('id', '!=', $portfolio->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('portfolio-detail', compact('portfolio', 'relatedPortfolios'));
    }

    public function getNewsPortal()
    {
        $articles = Content::where('type', 'article')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10); // Menampilkan 10 artikel per halaman dengan pagination

        return view('news-portal', compact('articles'));
    }
}
