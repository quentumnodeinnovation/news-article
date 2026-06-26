<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\DaVideo;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Section 1: Hero News

        // Center Hero Article (latest published article)
        $heroCenter = Article::with(['category', 'images', 'author'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('section_id', 21)
            ->latest('created_at')
            ->first();

        $currentMonthArticles = Article::with(['category', 'images', 'author'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->whereMonth('published_at', Carbon::now()->month)
            ->whereYear('published_at', Carbon::now()->year)
            ->when($heroCenter, function ($q) use ($heroCenter) {
                $q->where('id', '!=', $heroCenter->id);
            })
            ->inRandomOrder()
            ->take(12)
            ->get();

        $heroPool = $currentMonthArticles->values();

        $heroLeft = $heroPool->slice(0, 4);
        $heroRight = $heroPool->slice(4, 4);
        $heroExtra = $heroPool->slice(8)->values()->map(function ($article) {
            return [
                'slug' => $article->slug,
                'title' => $article->title,
                'featured_image' => $article->featured_image,
                'category' => $article->category->name ?? 'News',
                'author' => $article->auther ?? '',
            ];
        });

        $heroAll = $heroPool->values()->map(function ($article) {
            return [
                'slug' => $article->slug,
                'title' => $article->title,
                'featured_image' => $article->featured_image,
                'category' => $article->category->name ?? 'News',
                'author' => $article->auther ?? '',
            ];
        });

        // Left Side: Most Viewed Articles
        // $heroLeft = Article::with(['category', 'author'])
        //     ->where('status', 'published')
        //     ->whereNotNull('published_at')
        //     ->where('is_hero',1)
        //     ->when($heroCenter, function ($query) use ($heroCenter) {
        //         $query->where('id', '!=', $heroCenter->id);
        //     })
        //     ->orderByDesc('views')
        //     ->orderByDesc('published_at')
        //     ->take(3)
        //     ->get();
        // Right Side: Recent Articles
        // $heroRight = Article::with(['category', 'author'])
        //     ->where('status', 'published')
        //     ->whereNotNull('published_at')
        //     ->when($heroCenter, function ($query) use ($heroCenter) {
        //         $query->where('id', '!=', $heroCenter->id);
        //     })
        //     ->when($heroLeft->count(), function ($query) use ($heroLeft) {
        //         $query->whereNotIn('id', $heroLeft->pluck('id'));
        //     })
        //     ->latest('published_at')
        //     ->take(3)
        //     ->get();

        // Section 3: Monthly Edition News
        $monthlyEditionCategory = Category::where('slug', 'monthly-editions')
            ->where('status', 1)
            ->whereHas('articles', function ($q) {
                $q->where('status', 'published')
                    ->whereNotNull('published_at');
            })
            ->first();

        $monthlyEditionArticles = collect();

        if ($monthlyEditionCategory) {
            $monthlyEditionArticles = Article::with(['category', 'author'])
                ->where('category_id', $monthlyEditionCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->values();
        }

        // $breakingArticles = Article::with(['category', 'author'])
        //     ->where('status', 'published')
        //     ->where('category_id', $monthlyEditionCategoryId)
        //     ->whereNotNull('published_at')
        //     ->latest('published_at')
        //     ->take(5)
        //     ->get();

        // $breakingTop = $breakingArticles->slice(0, 3);
        // $breakingBottom = $breakingArticles->slice(3, 2)->values();

        // Section 4: Featured / Trending Stories
        $featuredArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->where('category_id', '!=', 21)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(6)
            ->get();

        // Sidebar categories
        $categories = Category::where('status', 1)
            ->where('slug', '!=', 'politics') // exclude politics here
            ->whereHas('articles', function ($query) {
                $query->where('status', 'published'); // only categories having published articles
            })
            ->withCount([
                'articles as articles_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Sidebar popular news
        $popularArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('category_id', '!=', 21)
            ->whereNotNull('published_at')
            ->orderByDesc('views')
            ->take(2)
            ->get();

        // Section 5: One category section
        $selectedCategory = Category::where('name', 'Business')->where('status', 1)
            ->whereHas('articles', function ($q) {
                $q->where('status', 'published');
            })
            ->first();

        $categoryArticles = collect();

        if ($selectedCategory) {
            $categoryArticles = Article::with(['category', 'author'])
                ->where('category_id', $selectedCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->take(9)
                ->get()
                ->values();
        }

        // Section 6: Asia In Brief
        $asiaInBriefCategory = Category::where('slug', 'asia-in-brief')
            ->where('status', 1)
            ->whereHas('articles', function ($q) {
                $q->where('status', 'published')
                    ->whereNotNull('published_at');
            })
            ->first();

        $asiaInBriefArticles = collect();

        if ($asiaInBriefCategory) {
            $asiaInBriefArticles = Article::with(['category', 'author'])
                ->where('category_id', $asiaInBriefCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->values();
        }

        // Politics Category
        $politicsCategory = Category::where('slug', 'politics')
            ->where('status', 1)
            ->first();

        $politicsArticles = collect();

        if ($politicsCategory) {
            $politicsArticles = Article::with(['category', 'author'])
                ->where('section_id', 22)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->take(7)
                ->get()
                ->values();
        }

        // Section: Bookshelf
        $bookshelfCategory = Category::where('slug', 'bookshelf')
            ->where('status', 1)
            ->whereHas('articles', function ($q) {
                $q->where('status', 'published')
                    ->whereNotNull('published_at');
            })
            ->first();

        $bookshelfArticles = collect();

        if ($bookshelfCategory) {
            $bookshelfArticles = Article::with(['category', 'author'])
                ->where('category_id', $bookshelfCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->values();
        }

        // Section: Lifestyle
        $lifestyleCategory = Category::where('slug', 'lifestyle')->where('status', 1)
            ->whereHas('articles', function ($q) {
                $q->where('status', 'published');
            })
            ->first();

        $lifestyleArticles = collect();

        if ($lifestyleCategory) {
            $lifestyleArticles = Article::with(['category', 'author'])
                ->where('category_id', $lifestyleCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->take(9)
                ->get()
                ->values();
        }

        $ctaPlan = SubscriptionPlan::where('id', 1)
            ->where('status', 1)
            ->first();

        $featuredVideos = DaVideo::latest()->limit(10)->get();

        return view('home', compact(
            'heroCenter',
            'heroLeft',
            'heroRight',
            'heroExtra',
            'heroAll',
            // 'breakingTop',
            // 'breakingBottom',
            'featuredArticles',
            'categories',
            'popularArticles',
            'selectedCategory',
            'categoryArticles',
            'ctaPlan',
            'asiaInBriefCategory',
            'asiaInBriefArticles',
            'bookshelfCategory',
            'bookshelfArticles',
            'lifestyleCategory',
            'lifestyleArticles',
            'politicsCategory',
            'politicsArticles',
            'monthlyEditionCategory',
            'monthlyEditionArticles',
            'featuredVideos'
        ));
    }

    public function newHome()
    {
        // Get current and previous month dates
        // $currentMonth = Carbon::now();
        // $previousMonth = Carbon::now()->subMonth();
        // $previousToPreviousMonth = Carbon::now()->subMonths(2);

        $currentDate = Carbon::now();

        // If date > 25 → shift to next month
        if ($currentDate->day > 25) {
            $editorialMonth = $currentDate->copy()->addMonth();
        } else {
            $editorialMonth = $currentDate->copy();
        }

        // These are recalculated below if the next-month fallback is needed.
        $currentMonth = $editorialMonth;
        $previousMonth = $editorialMonth->copy()->subMonth();
        $previousToPreviousMonth = $editorialMonth->copy()->subMonths(2);

        // Fetch all categories 
        $politicsCategory = Category::where('slug', 'politics')->where('status', 1)->first();

        $lifestyleCategory = Category::where('slug', 'lifestyle')->where('status', 1)->first();

        $bookshelfCategory = Category::where('slug', 'bookshelf')->where('status', 1)->first();

        $businessCategory = Category::where('slug', 'business')->where('status', 1)->first();

        $democracyCategory = Category::where('slug', 'democracy')->where('status', 1)->first();

        $securityCategory = Category::where('slug', 'security')->where('status', 1)->first();

        $monthlyEditionCategory = Category::where('slug', 'monthly-editions')->where('status', 1)->first();

        if (!$editorialMonth->isSameMonth($currentDate)) {
            $heroCategoryIds = collect([
                $lifestyleCategory?->id,
                $bookshelfCategory?->id,
                $democracyCategory?->id,
                $securityCategory?->id,
            ])->filter()->values();

            $hasNextMonthHeroArticles = Article::where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $editorialMonth->month)
                ->whereYear('published_at', $editorialMonth->year)
                ->where(function ($query) use ($heroCategoryIds) {
                    $query->where('section_id', 22);

                    if ($heroCategoryIds->isNotEmpty()) {
                        $query->orWhereIn('category_id', $heroCategoryIds);
                    }
                })
                ->exists();

            if (!$hasNextMonthHeroArticles) {
                $editorialMonth = $currentDate->copy();
            }

            // Keep "Featured stories from last month" relative to the visible home month.
            $currentMonth = $editorialMonth;
            $previousMonth = $editorialMonth->copy()->subMonth();
            $previousToPreviousMonth = $editorialMonth->copy()->subMonths(2);
        }

        // ===== SECTION 1: Hero Section =====
        // Get Political Articles (Center + Left: 2 + 1)

        $politicsArticles = collect();
        if ($politicsCategory) {
            $politicsArticles = Article::with(['category', 'author'])
                ->where('section_id', 22)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $currentMonth->month)
                ->whereYear('published_at', $currentMonth->year)
                ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->take(7)
                ->get()
                ->values();
        }

        $heroCenter = $politicsArticles->first(); // 1 political article for center
        $heroLeft = $politicsArticles->slice(1, 2)->values(); // 2 political articles for left

        // Get Bookshelf and lifestyle Article for right side (latest from current month)

        // Initialize first
        $heroRightArticle = collect();

        $heroRightMainArticle = collect();

        $heroRightPriority = [
            $lifestyleCategory,
            $securityCategory,
            $democracyCategory,
        ];

        foreach ($heroRightPriority as $category) {

            if (!$category) {
                continue;
            }

            $article = Article::with(['category', 'author'])
                ->where('category_id', $category->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $currentMonth->month)
                ->whereYear('published_at', $currentMonth->year)
                ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->take(1)
                ->get();

            if ($article->isNotEmpty()) {
                $heroRightMainArticle = $article;
                break; // stop at first available
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BOOKSHELF ARTICLE (latest)
        |--------------------------------------------------------------------------
        */

        $bookshelfHeroArticle = collect();

        if ($bookshelfCategory) {
            $bookshelfHeroArticle = Article::with(['category', 'author'])
                ->where('category_id', $bookshelfCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $currentMonth->month)
                ->whereYear('published_at', $currentMonth->year)
                ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->latest('published_at')
                ->take(1)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | MERGE BOTH
        |--------------------------------------------------------------------------
        */
        $heroRightArticle = $bookshelfHeroArticle
            ->merge($heroRightMainArticle)
            ->values();

        // ===== SECTION 2: Grid Section (8 articles, 4 per row, current month) =====
        // Get 8 articles from current month but NOT from section 1
        $heroArticleIds = collect()
            ->push($heroCenter?->id)
            ->merge($heroLeft->pluck('id'))
            ->merge($heroRightArticle->pluck('id'))
            ->filter();

        $remainingLimit = 8;
        $gridArticles = collect();

        // Start exclusion with hero articles
        $excludeIds = collect($heroArticleIds);

        /*
        |--------------------------------------------------------------------------
        | 1. POLITICS (SPECIAL HANDLING - section_id)
        |--------------------------------------------------------------------------
        */
        if ($remainingLimit > 0 && $politicsCategory) {

            $politicsArticles = Article::with(['category', 'author'])
                ->where('section_id', 22) // special condition
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $currentMonth->month)
                ->whereYear('published_at', $currentMonth->year)
                ->whereNotIn('id', $excludeIds)
                ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->take($remainingLimit)
                ->get();

            $gridArticles = $gridArticles->merge($politicsArticles);

            $remainingLimit -= $politicsArticles->count();
            $excludeIds = $excludeIds->merge($politicsArticles->pluck('id'));
        }

        /*
        |--------------------------------------------------------------------------
        | 2. OTHER CATEGORIES (DYNAMIC LOOP)
        |--------------------------------------------------------------------------
        */
        // $priorityCategories = [
        //     $democracyCategory,
        //     $businessCategory,
        //     $securityCategory,
        //     $lifestyleCategory,
        //     $bookshelfCategory,
        // ];

        $priorityCategories = Category::where('status', 1)
            ->where('main_menu', 1)
            ->whereNotIn('slug', ['politics', 'monthly-editions'])
            ->orderBy('sort_order')
            ->get();

        foreach ($priorityCategories as $category) {

            if ($remainingLimit <= 0) {
                break;
            }

            if (!$category) {
                continue;
            }

            $articles = Article::with(['category', 'author'])
                ->where('category_id', $category->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $currentMonth->month)
                ->whereYear('published_at', $currentMonth->year)
                ->whereNotIn('id', $excludeIds)
                ->orderByDesc('published_at')
                ->take($remainingLimit)
                ->get();

            $gridArticles = $gridArticles->merge($articles);

            $remainingLimit -= $articles->count();
            $excludeIds = $excludeIds->merge($articles->pluck('id'));
        }

        /*
        |--------------------------------------------------------------------------
        | FINAL RESULT
        |--------------------------------------------------------------------------
        */
        $gridArticles = $gridArticles->values();

        $popularArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('category_id', '!=', 21)
            ->whereNotNull('published_at')
            ->orderByDesc('views')
            ->take(2)
            ->get();

        // ===== SECTION 4: Previous Month Articles (Grouped by Category) =====
        $previousMonthArticles = collect();

        $categoriesOrder = [
            'politics' => ['type' => 'section', 'value' => 22],
            'business' => ['type' => 'slug'],
            'lifestyle' => ['type' => 'slug'],
            'bookshelf' => ['type' => 'slug'],
        ];

        foreach ($categoriesOrder as $slug => $config) {

            if ($config['type'] === 'section') {
                $articles = Article::with(['category', 'author'])
                    ->where('section_id', $config['value'])
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->whereMonth('published_at', $previousMonth->month)
                    ->whereYear('published_at', $previousMonth->year)
                    ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                    ->orderBy('sort_order')
                    ->latest('published_at')
                    ->get();
            } else {
                $category = Category::where('slug', $slug)->where('status', 1)->first();

                if (!$category)
                    continue;

                $articles = Article::with(['category', 'author'])
                    ->where('category_id', $category->id)
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->whereMonth('published_at', $previousMonth->month)
                    ->whereYear('published_at', $previousMonth->year)
                    ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                    ->orderBy('sort_order')
                    ->latest('published_at')
                    ->get();
            }

            if ($articles->isNotEmpty()) {
                $previousMonthArticles->push([
                    'category' => ucfirst($slug),
                    'articles' => $articles
                ]);
            }
        }

        $featuredVideos = DaVideo::latest()->limit(10)->get();

        // Fetching all categories articles 

        $politicsSectionArticles = collect();

        if ($politicsCategory) {

            $politicsSectionArticles = Article::with(['category', 'author'])
                ->where('section_id', 22)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $previousToPreviousMonth->month)
                ->whereYear('published_at', $previousToPreviousMonth->year)
                ->orderByDesc('published_at')
                ->take(7)
                ->get()
                ->values();

            if ($politicsSectionArticles->count() < 7) {
                $politicsSectionArticles = Article::with(['category', 'author'])
                    ->where('section_id', 22)
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
                    ->orderBy('sort_order')
                    ->orderByDesc('published_at')
                    ->take(7)
                    ->get()
                    ->values();
            }
        }

        $businessArticles = collect();

        if ($businessCategory) {

            // Step 1: Try previous to previous month
            $businessArticles = Article::with(['category', 'author'])
                ->where('category_id', $businessCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $previousToPreviousMonth->month)
                ->whereYear('published_at', $previousToPreviousMonth->year)
                ->orderByDesc('published_at')
                ->take(9)
                ->get()
                ->values();

            // Step 2: Fallback if not enough
            if ($businessArticles->count() < 9) {
                $businessArticles = Article::with(['category', 'author'])
                    ->where('category_id', $businessCategory->id)
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->orderByDesc('published_at')
                    ->take(9)
                    ->get()
                    ->values();
            }
        }

        $bookshelfArticles = collect();
        if ($bookshelfCategory) {
            $bookshelfArticles = Article::with(['category', 'author'])
                ->where('category_id', $bookshelfCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->values();
        }

        $lifestyleArticles = collect();

        if ($lifestyleCategory) {

            $lifestyleArticles = Article::with(['category', 'author'])
                ->where('category_id', $lifestyleCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereMonth('published_at', $previousToPreviousMonth->month)
                ->whereYear('published_at', $previousToPreviousMonth->year)
                ->orderByDesc('published_at')
                ->take(4)
                ->get()
                ->values();

            if ($lifestyleArticles->count() < 4) {
                $lifestyleArticles = Article::with(['category', 'author'])
                    ->where('category_id', $lifestyleCategory->id)
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->orderByDesc('published_at')
                    ->take(4)
                    ->get()
                    ->values();
            }
        }

        $monthlyEditionArticles = collect();
        if ($monthlyEditionCategory) {
            $monthlyEditionArticles = Article::with(['category', 'author'])
                ->where('category_id', $monthlyEditionCategory->id)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->values();
        }

        return view('new-home', compact(
            'heroCenter',
            'heroLeft',
            'heroRightArticle',
            'gridArticles',
            'previousMonthArticles',
            'popularArticles',
            'featuredVideos',
            'politicsCategory',
            'lifestyleCategory',
            'bookshelfCategory',
            'businessCategory',
            'monthlyEditionCategory',
            'politicsSectionArticles',
            'businessArticles',
            'bookshelfArticles',
            'lifestyleArticles',
            'monthlyEditionArticles'
        ));
    }

    public function newsIndex()
    {
        $articles = Article::with(['category', 'author', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(12)->withQueryString();

        $popularArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('category_id', '!=', 21)
            ->whereNotNull('published_at')
            ->orderByDesc('views')
            ->take(3)
            ->get();

        $categories = Category::where('status', 1)
            ->whereHas('articles', function ($query) {
                $query->where('status', 'published'); // only categories having published articles
            })
            ->withCount([
                'articles as articles_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $sidebarTags = Tag::withCount([
            'articles' => function ($q) {
                $q->where('status', 'published')
                    ->whereNotNull('published_at');
            }
        ])
            ->having('articles_count', '>', 0)
            ->orderByDesc('articles_count')
            ->take(14)
            ->get();

        $pageTitle = 'News';
        $pageType = 'news';
        $pageObject = null;

        return view('news.index', compact(
            'articles',
            'popularArticles',
            'categories',
            'sidebarTags',
            'pageTitle',
            'pageType',
            'pageObject'
        ));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $articleQuery = Article::with(['category', 'author', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderByRaw('YEAR(published_at) DESC, MONTH(published_at) DESC')
            ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
            ->orderBy('sort_order', 'asc')
            ->orderBy('published_at', 'desc');

        if ($slug === 'politics') {
            $articleQuery->where('section_id', 22);
        } else {
            $articleQuery->where('category_id', $category->id);
        }

        if ($slug === 'monthly-editions') {
            $latestArticle = Article::with(['category', 'author', 'tags'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('category_id', $category->id)
                ->latest('published_at')
                ->first();

            $otherArticles = Article::with(['category', 'author', 'tags'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('category_id', $category->id)
                ->when($latestArticle, function ($query) use ($latestArticle) {
                    $query->where('id', '!=', $latestArticle->id);
                })
                ->latest('published_at')
                ->paginate(12)->withQueryString();

            $pageTitle = $category->name;
            $pageType = 'category';
            $pageObject = $category;

            return view('news.monthly-edition', compact(
                'latestArticle',
                'otherArticles',
                'pageTitle',
                'pageType',
                'pageObject'
            ));
        }

        if ($slug === 'asia-in-brief') {
            $latestArticle = Article::with(['category', 'author', 'tags'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('category_id', $category->id)
                ->latest('published_at')
                ->first();

            $otherArticles = Article::with(['category', 'author', 'tags'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('category_id', $category->id)
                ->when($latestArticle, function ($query) use ($latestArticle) {
                    $query->where('id', '!=', $latestArticle->id);
                })
                ->latest('published_at')
                ->paginate(12)->withQueryString();

            $pageTitle = $category->name;
            $pageType = 'category';
            $pageObject = $category;

            return view('news.asia-this-month', compact(
                'latestArticle',
                'otherArticles',
                'pageTitle',
                'pageType',
                'pageObject'
            ));
        }
        if ($slug === 'editorial') {
            $latestArticle = Article::with(['category', 'author', 'tags'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('category_id', $category->id)
                ->latest('published_at')
                ->first();

            $otherArticles = Article::with(['category', 'author', 'tags'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('category_id', $category->id)
                ->when($latestArticle, function ($query) use ($latestArticle) {
                    $query->where('id', '!=', $latestArticle->id);
                })
                ->latest('published_at')
                ->paginate(12)->withQueryString();

            $pageTitle = $category->name;
            $pageType = 'category';
            $pageObject = $category;

            return view('news.editorial', compact(
                'latestArticle',
                'otherArticles',
                'pageTitle',
                'pageType',
                'pageObject'
            ));
        }

        $articles = $articleQuery
            ->paginate(12)
            ->withQueryString();

        $popularArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('category_id', '!=', 21)
            ->whereNotNull('published_at')
            ->orderByDesc('views')
            ->take(3)
            ->get();

        $categories = Category::where('status', 1)
            ->whereHas('articles', function ($query) {
                $query->where('status', 'published'); // only categories having published articles
            })
            ->withCount([
                'articles as articles_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $sidebarTags = Tag::withCount([
            'articles' => function ($q) {
                $q->where('status', 'published')
                    ->whereNotNull('published_at');
            }
        ])
            ->having('articles_count', '>', 0)
            ->orderByDesc('articles_count')
            ->take(14)
            ->get();

        $pageTitle = $category->name;
        $pageType = 'category';
        $pageObject = $category;

        return view('news.index', compact(
            'articles',
            'popularArticles',
            'categories',
            'sidebarTags',
            'pageTitle',
            'pageType',
            'pageObject'
        ));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $articles = Article::with(['category', 'author', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            })
            ->latest('published_at')
            ->paginate(12)->withQueryString();

        $popularArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('category_id', '!=', 21)
            ->whereNotNull('published_at')
            ->orderByDesc('views')
            ->take(3)
            ->get();

        $categories = Category::where('status', 1)
            ->whereHas('articles', function ($query) {
                $query->where('status', 'published'); // only categories having published articles
            })
            ->withCount([
                'articles as articles_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $sidebarTags = Tag::withCount([
            'articles' => function ($q) {
                $q->where('status', 'published')
                    ->whereNotNull('published_at');
            }
        ])
            ->having('articles_count', '>', 0)
            ->orderByDesc('articles_count')
            ->take(14)
            ->get();

        $pageTitle = $tag->name;
        $pageType = 'tag';
        $pageObject = $tag;

        return view('news.index', compact(
            'articles',
            'popularArticles',
            'categories',
            'sidebarTags',
            'pageTitle',
            'pageType',
            'pageObject'
        ));
    }
    public function newsDetailSlug($slug)
    {
        $article = Article::with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->firstOrFail();

        $article->increment('views');

        $relatedArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        $popularArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('category_id', '!=', 21)
            ->whereNotNull('published_at')
            ->where('id', '!=', $article->id)
            ->orderByDesc('views')
            ->take(3)
            ->get();

        $categories = Category::where('status', 1)
            ->whereHas('articles', function ($query) {
                $query->where('status', 'published'); // only categories having published articles
            })
            ->withCount([
                'articles as articles_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $sidebarTags = Tag::withCount([
            'articles' => function ($q) {
                $q->where('status', 'published')
                    ->whereNotNull('published_at');
            }
        ])
            ->having('articles_count', '>', 0)
            ->orderByDesc('articles_count')
            ->take(14)
            ->get();

        return view('news.news-detail', compact(
            'article',
            'relatedArticles',
            'popularArticles',
            'categories',
            'sidebarTags'
        ));
    }

    public function newsletterSubscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = trim(strtolower($request->email));

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => strtok($email, '@'),
                'email' => $email,
                'password' => Hash::make('user@123'),
                'role' => 'user',
            ]);
        }

        Auth::login($user);

        $message = $request->mode === 'login'
            ? 'Login successful.'
            : 'Subscribed successfully.';

        return redirect()->back()->with([
            'newsletter_success' => $message,
            'newsletter_mode' => $request->mode // 👈 ADD THIS
        ]);
    }
}
