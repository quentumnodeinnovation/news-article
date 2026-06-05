<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = config('app.url');

        // Collect all URLs with their metadata
        $urls = [];

        // Static routes
        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ];

        $urls[] = [
            'loc' => route('news.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.9',
        ];

        // $urls[] = [
        //     'loc' => route('frontend.plans.index'),
        //     'lastmod' => now()->toAtomString(),
        //     'changefreq' => 'weekly',
        //     'priority' => '0.8',
        // ];

        $urls[] = [
            'loc' => route('contact.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ];

        // Dynamic routes - Articles
        $articles = Article::where('status', 'published')
            ->select('slug', 'updated_at')
            ->get();

        foreach ($articles as $article) {
            $urls[] = [
                'loc' => route('news.show', $article->slug),
                'lastmod' => $article->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Dynamic routes - Categories
        $categories = Category::where('status', 1)
            ->select('slug', 'updated_at')
            ->get();

        foreach ($categories as $category) {
            $urls[] = [
                'loc' => route('category.show', $category->slug),
                'lastmod' => $category->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Dynamic routes - Tags
        // $tags = Tag::select('slug', 'updated_at')->get();

        // foreach ($tags as $tag) {
        //     $urls[] = [
        //         'loc' => route('tag.show', $tag->slug),
        //         'lastmod' => $tag->updated_at->toAtomString(),
        //         'changefreq' => 'weekly',
        //         'priority' => '0.6',
        //     ];
        // }

        // Dynamic routes - Subscription Plans
        // $plans = SubscriptionPlan::where('status', 1)
        //     ->select('slug', 'updated_at')
        //     ->get();

        // foreach ($plans as $plan) {
        //     $urls[] = [
        //         'loc' => route('plans.subscribe.show', $plan->slug),
        //         'lastmod' => $plan->updated_at->toAtomString(),
        //         'changefreq' => 'monthly',
        //         'priority' => '0.7',
        //     ];
        // }

        return Response::view('sitemap', ['urls' => $urls], 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=86400', // Cache for 24 hours
        ]);
    }
}
