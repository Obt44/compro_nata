<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Category;
use Illuminate\Http\Request;

class InsightController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::where('type', 'article')
            ->where('status', 'published');

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhere('meta_description', 'like', "%{$searchTerm}%");
            });
        }

        // Handle date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('published_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('published_at', '<=', $request->end_date);
        }

        // Handle category filter
        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // Get articles with pagination
        $articles = $query->orderBy('published_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get all categories for the filter
        $categories = Category::all();

        return view('insights', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Content::where('type', 'article')
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $article->increment('views');

        // Get related articles (3 latest articles excluding current article)
        $relatedArticles = Content::where('type', 'article')
            ->where('status', 'published')
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('article', compact('article', 'relatedArticles'));
    }
}
