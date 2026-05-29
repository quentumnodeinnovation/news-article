@extends('layouts.app')
@section('content')
    <!-- SECTION 1: Hero Area -->
    <section class="rs-banner-area rs-banner-six section-space-top">
        <div class="container">
            <div class="row g-4 align-items-stretch gap-on-mobile">

                <!-- Mobile Top news  -->
                <div class="hide-on-desktop col-xl-5 col-lg-5 d-flex">
                    @if($heroCenter)
                        <div class="custom-hero-card">

                            {{-- IMAGE --}}
                            <div class="hero-card-thumb">
                                <a href="{{ route('news.show', $heroCenter->slug) }}">
                                    <img src="{{ $heroCenter->featured_image ? asset('storage/' . $heroCenter->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                        alt="{{ $heroCenter->title }}">
                                </a>
                            </div>

                            {{-- CONTENT --}}
                            <div class="hero-card-content"
                                style="padding: 15px 0 10px 0; border-bottom: 1px solid var(--rs-border-primary);">

                                {{-- CATEGORY --}}
                                <div class="news-category">
                                    <a href="javascript:void(0)">
                                        {{ $heroCenter->category->name ?? 'News' }}
                                    </a>
                                </div>

                                {{-- TITLE --}}
                                <h3 class="rs-post-small-title underline news-title">
                                    <a href="{{ route('news.show', $heroCenter->slug) }}">
                                        {{ \Illuminate\Support\Str::limit($heroCenter->title, 80) }}
                                    </a>
                                </h3>

                                {{-- META --}}
                                @if(!empty($heroCenter->auther))
                                    <div class="rs-post-meta">
                                        <ul>
                                            <li><span class="rs-meta">By<a href="#"
                                                        class="meta-author">{{ $heroCenter->auther }}</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @else
                        <div class="text-center w-100 py-5">
                            <p>No Featured Article</p>
                        </div>
                    @endif
                </div>

                {{-- LEFT: 2 Political Articles (25% Width) --}}
                <div class="col-xl-4 col-lg-4 d-flex" style="border-right: 1px solid var(--rs-border-primary);">
                    <div class="rs-banner-small-post">
                        <div class="rs-post-small rs-post-small-seventeen">
                            @forelse($heroLeft as $article)
                                <div class="rs-post-small-item mb-20">
                                    <div class="rs-post-small-thumb" style="border-radius: 3px;">
                                        <a href="{{ route('news.show', $article->slug) }}" class="image-link">
                                            <img class="hero-side-image"
                                                src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                                alt="{{ $article->title }}">
                                        </a>
                                    </div>
                                    <div class="rs-post-small-content">
                                        <div class="rs-post-tag-two">
                                            <a href="javascript:void(0)" class="news-category">
                                                {{ $article->category->name ?? 'News' }}
                                            </a>
                                        </div>
                                        <h6 class="rs-post-small-title underline big-font-size" style="margin:0;">
                                            <a href="{{ route('news.show', $article->slug) }}">
                                                {{ \Illuminate\Support\Str::limit($article->title, 65) }}
                                            </a>
                                        </h6>
                                        @if(!empty($article->auther))
                                            <div class="rs-post-meta">
                                                <ul>
                                                    <li><span class="rs-meta">By<a href="#"
                                                                class="meta-author">{{ $article->auther }}</a></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p>No articles found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- CENTER: 1 Main Political Article (50% Width) --}}
                <div class="hide-on-mobile col-xl-5 col-lg-5 d-flex">
                    @if($heroCenter)
                        <div class="custom-hero-card">

                            {{-- IMAGE --}}
                            <div class="hero-card-thumb">
                                <a href="{{ route('news.show', $heroCenter->slug) }}">
                                    <img src="{{ $heroCenter->featured_image ? asset('storage/' . $heroCenter->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                        alt="{{ $heroCenter->title }}">
                                </a>
                            </div>

                            {{-- CONTENT --}}
                            <div class="hero-card-content">

                                {{-- CATEGORY --}}
                                <div class="news-category">
                                    <a href="javascript:void(0)">
                                        {{ $heroCenter->category->name ?? 'News' }}
                                    </a>
                                </div>

                                {{-- TITLE --}}
                                <h3 class="rs-post-small-title underline">
                                    <a href="{{ route('news.show', $heroCenter->slug) }}">
                                        {{ \Illuminate\Support\Str::limit($heroCenter->title, 80) }}
                                    </a>
                                </h3>

                                {{-- META --}}
                                @if(!empty($heroCenter->auther))
                                    <div class="rs-post-meta">
                                        <ul>
                                            <li><span class="rs-meta">By<a href="#"
                                                        class="meta-author">{{ $heroCenter->auther }}</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @else
                        <div class="text-center w-100 py-5">
                            <p>No Featured Article</p>
                        </div>
                    @endif
                </div>

                <div class="hide-on-desktop" style="height: 1px; border: 1px solid var(--rs-border-primary);"></div>

                {{-- RIGHT: 1 Bookshelf Article + Advertisement (25% Width) --}}
                <div class="col-xl-3 col-lg-3 d-flex flex-column gap-4">
                    <div class="rs-banner-small-post">
                        <div class="rs-post-small rs-post-small-seventeen">
                            @forelse($heroRightArticle as $article)
                                <div class="rs-post-small-item mb-20">
                                    <div class="rs-post-small-thumb right-article-image"
                                        style="min-width: 110px; border-radius: 3px;">
                                        <a href="{{ route('news.show', $article->slug) }}" class="image-link">
                                            <img class="hero-side-image"
                                                src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                                alt="{{ $article->title }}">
                                        </a>
                                    </div>
                                    <div class="rs-post-small-content">
                                        <div class="news-category">
                                            <a href="javascript:void(0)" class="post-tag is-green">
                                                {{ $article->category->name ?? 'News' }}
                                            </a>
                                        </div>
                                        <h6 class="rs-post-small-title underline news-title">
                                            <a href="{{ route('news.show', $article->slug) }}">
                                                {{ \Illuminate\Support\Str::limit($article->title, 45) }}
                                            </a>
                                        </h6>
                                        @if(!empty($article->auther))
                                            <div class="rs-post-meta">
                                                <ul>
                                                    <li><span class="rs-meta">By <a href="#"
                                                                class="meta-author">{{ $article->auther }}</a></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p>No articles found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Advertisement Box --}}
                    <!-- <div class="mt-auto">
                                                                                <x-advertisement-box width="100%" height="100%" style="min-height: 100px;" />
                                                                            </div> -->
                </div>
            </div>
        </div>

        <style>
            .rs-post-overlay-one {
                position: relative;
                height: 100%;
                min-height: 400px;
                display: flex;
                flex-direction: column;
            }

            .rs-post-overlay-one .rs-post-overlay-bg-thumb {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
            }

            .rs-post-overlay-content {
                position: relative;
                z-index: 2;
                padding: 30px;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                height: 100%;
                background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.8) 100%);
            }

            .rs-post-small-item {
                display: flex;
                gap: 15px;
                align-items: flex-start;
                flex: 1;
            }

            .rs-post-small-thumb {
                flex: 0 0 100px;
            }

            .rs-post-small-content {
                flex: 1;
            }

            .rs-banner-small-post {
                width: 100%;
                height: 100%;
            }

            .rs-post-small-seventeen {
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .hero-side-image {
                width: 100%;
                height: 80px;
                object-fit: cover;
                border-radius: 6px;
            }

            .custom-hero-card {
                width: 100%;
                background: #fff;
                border-radius: 3px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .hero-card-thumb {
                width: 100%;
                aspect-ratio: 19/9;
                overflow: hidden;
            }

            .hero-card-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
            }

            .hero-card-thumb:hover img {
                transform: scale(1.05);
            }

            .hero-card-content {
                padding: 15px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }

            .hero-card-title {
                font-size: 22px;
                font-weight: 600;
                margin-bottom: 10px;
                line-height: 1.2;
            }

            .hero-card-title a {
                color: #111827;
                text-decoration: none;
            }

            .hero-card-meta {
                font-size: 14px;
                color: #6b7280;
                margin-bottom: 10px;
            }

            .hero-card-meta span {
                color: #374151;
                font-weight: 500;
            }

            .big-font-size {
                font-size: 23px !important;
            }

            @media (max-width: 768px) {
                .hero-card-thumb {
                    aspect-ratio: auto;
                }

                .big-font-size {
                    font-size: 19px !important;
                }

                .right-article-image {
                    flex: 0 0 140px !important;
                    min-height: 130px !important;
                    height: 100% !important;
                }
            }
        </style>
    </section>

    <!-- SECTION 2: Grid Articles (3 Per Row) -->
    <section class="rs-trending-news-area" style="padding-top:60px; padding-bottom: 10px;">
        <div class="container">
            <div class="row g-5" style="border-top: 1px solid var(--rs-border-primary);">
                {{-- Left: Articles Grid (3 per row) --}}
                <div class="col-xl-9 col-lg-9">
                    <div class="row g-0 rs-grid-divider-2">
                        @forelse($gridArticles as $article)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                                <div class="rs-post-vertical-card">

                                    {{-- IMAGE --}}
                                    <div class="rs-post-v-thumb">
                                        <a href="{{ route('news.show', $article->slug) }}">
                                            <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                                alt="{{ $article->title }}">
                                        </a>
                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="rs-post-v-content">

                                        <div class="news-category">
                                            {{ $article->category->name ?? 'News' }}
                                        </div>

                                        <h6 class="rs-post-small-title underline">
                                            <a href="{{ route('news.show', $article->slug) }}">
                                                {{ \Illuminate\Support\Str::limit($article->title, 70) }}
                                            </a>
                                        </h6>

                                        @if(!empty($article->auther))
                                            <div class="rs-post-meta">
                                                <ul>
                                                    <li><span class="rs-meta">By<a href="#"
                                                                class="meta-author">{{ $article->auther }}</a></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-4">
                                    <p>No articles found</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Right: Advertisement --}}
                <div class="col-xl-3 col-lg-3">
                    <!-- <x-advertisement-box width="100%" height="100%" style="min-height: 250px;" /> -->
                    @include('components.advertisement-box', [
                        'width' => '100%',
                        'height' => '100%',
                        'min-height' => '250px',
                        'image' => asset('assets/images/ad/kingfisher-ad.jpeg'),
                        'class' => ''
                    ])
                </div>
            </div>
        </div>

        <style>
            .rs-post-overlay-two {
                position: relative;
                overflow: hidden;
                border-radius: 8px;
                display: flex;
                flex-direction: column;
            }

            .rs-post-overlay-two .rs-post-overlay-bg-thumb {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
                transition: transform 0.3s ease;
            }

            .rs-post-overlay-two:hover .rs-post-overlay-bg-thumb {
                transform: scale(1.05);
            }

            .rs-post-overlay-two .rs-post-overlay-content {
                position: relative;
                z-index: 2;
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                height: 100%;
                min-height: 250px;
                background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.9) 100%);
            }

            /* Vertical Card */
            .rs-post-vertical-card {
                padding: 15px;
                height: 100%;
                background: #fff;
                transition: all 0.3s ease;
            }

            /* GRID BASE */
            .rs-grid-divider-2>div {
                position: relative;
            }

            /* ✅ Y-axis (Horizontal line) */
            .rs-grid-divider-2>div {
                border-bottom: 1px solid var(--rs-border-primary);
            }

            /* remove bottom border from last row (4 items per row) */
            .rs-grid-divider-2>div:nth-last-child(-n+4) {
                border-bottom: none;
            }

            /* ✅ X-axis (Short vertical divider) */
            .rs-grid-divider-2>div:not(:nth-child(4n))::after {
                content: "";
                position: absolute;
                top: 25px;
                /* spacing from top */
                bottom: 25px;
                /* spacing from bottom (important) */
                right: 0;
                width: 1px;
                background: var(--rs-border-primary);
            }

            @media (max-width: 768px) {

                /* 2 columns → adjust vertical divider */
                .rs-grid-divider-2>div:not(:nth-child(2n))::after {
                    content: "";
                    position: absolute;
                    top: 15px;
                    bottom: 15px;
                    right: 0;
                    width: 1px;
                    background: var(--rs-border-primary);
                }

                /* remove old 4-column divider */
                .rs-grid-divider-2>div:not(:nth-child(4n))::after {
                    display: none;
                }

                /* bottom border fix (last row = 2 items) */
                .rs-grid-divider-2>div:nth-last-child(-n+2) {
                    border-bottom: none;
                }
            }

            @media (max-width: 768px) {

                .rs-post-vertical-card {
                    padding: 10px;
                }

                .rs-post-v-thumb {
                    margin-bottom: 6px;
                }

                .news-category {
                    font-size: 10px;
                    margin-bottom: 2px;
                }

                .rs-post-small-title {
                    font-size: 15px;
                    line-height: 1.3;
                }
            }

            .rs-post-vertical-card:hover {
                background: #fafafa;
            }

            /* IMAGE */
            .rs-post-v-thumb {
                width: 100%;
                aspect-ratio: 16/10;
                overflow: hidden;
                margin-bottom: 10px;
            }

            .rs-post-v-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
            }

            .rs-post-vertical-card:hover img {
                transform: scale(1.05);
            }

            /* CONTENT */
            .rs-post-v-content {
                display: flex;
                flex-direction: column;
            }

            .rs-post-v-title {
                font-size: 16px;
                font-weight: 600;
                line-height: 1.2;
                margin: 0;
            }

            .rs-post-v-title a {
                color: #111;
                text-decoration: none;
            }

            .rs-post-v-title a:hover {
                text-decoration: underline;
            }

            @media (max-width: 768px) {
                .rs-post-vertical-card {
                    border-right: none;
                    border-bottom: 1px solid var(--rs-border-primary);
                }
            }
        </style>
    </section>

    <!-- SECTION 3: Highlight Stories (Videos Section) -->
    @include('components.highlight-video');

    <!-- SECTION 4: Previous Month Articles (Single Slider with All Categories) -->
    <section class="rs-trending-news-area" style="padding: 20px 0;">
        <div class="container">
            <div class="row align-items-center g-5" style="margin-bottom:10px;">
                <div class="col-xl-6 col-lg-6">
                    <div class="section-title-wrapper">
                        <h2 class="section-title is-black">
                            Featured stories from last month
                        </h2>
                    </div>
                </div>
            </div>

            <div class="row g-5">
                {{-- Left: Previous Month Articles (Single Slider with Category Headings per Category) --}}
                <div class="col-xl-9 col-lg-9">
                    @php
                        $categorySlides = [];

                        foreach ($previousMonthArticles as $categoryGroup) {
                            if ($categoryGroup['articles'] && $categoryGroup['articles']->count() > 0) {
                                $categoryName = $categoryGroup['category'];
                                $articles = $categoryGroup['articles'];
                                $chunks = $articles->chunk(4);

                                foreach ($chunks as $chunk) {
                                    $categorySlides[] = [
                                        'category' => $categoryName,
                                        'articles' => $chunk
                                    ];
                                }
                            }
                        }
                    @endphp

                    @if($categorySlides && count($categorySlides) > 0)
                        <div class="swiper rs-all-articles-slider">
                            <div class="swiper-wrapper">
                                @foreach($categorySlides as $slide)
                                    <div class="swiper-slide">
                                        {{-- Category Heading --}}
                                        <div class="category-header-block">
                                            <h3 class="category-header-title">{{ $slide['category'] }}</h3>
                                        </div>

                                        <div class="row g-4 rs-grid-divider-4">
                                            @foreach($slide['articles'] as $article)
                                                <div class="col-xl-6 col-lg-6 col-md-6" style="margin-top: 0;">
                                                    <div class="news-clean-item">

                                                        <div class="news-clean-content">
                                                            <div class="news-category">
                                                                {{ $article->category->name ?? 'News' }}
                                                            </div>

                                                            <h3 class="news-title rs-post-small-title underline">
                                                                <a href="{{ route('news.show', $article->slug) }}">
                                                                    {{$article->title}}
                                                                </a>
                                                            </h3>

                                                            @if(!empty($article->auther))
                                                                <div class="rs-post-meta">
                                                                    <ul>
                                                                        <li><span class="rs-meta">By<a href="#"
                                                                                    class="meta-author">{{ $article->auther }}</a></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="news-thumb">
                                                            <a href="{{ route('news.show', $article->slug) }}">
                                                                <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                                                    alt="{{ $article->title }}">
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="slider-nav global-nav">
                                <div class="swiper-button-prev articles-slider-prev">
                                    <i class="ri-arrow-left-s-line"></i>
                                </div>
                                <div class="swiper-button-next articles-slider-next">
                                    <i class="ri-arrow-right-s-line"></i>
                                </div>
                            </div>

                            {{-- Pagination --}}
                            <div class="swiper-pagination articles-slider-pagination"></div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="text-center py-4">
                                <p>No articles found for previous month</p>
                            </div>
                        </div>
                    @endif
                </div>


                {{-- Right: Advertisement --}}
                <div class="col-xl-3 col-lg-3">
                    <x-advertisement-box width="100%" height="100%" style="min-height: 300px;" />
                </div>
            </div>
        </div>
        <style>
            /* Single Articles Slider */
            .rs-all-articles-slider {
                position: relative;
            }

            .rs-all-articles-slider .swiper-wrapper {
                display: flex;
            }

            .rs-all-articles-slider .swiper-slide {
                width: 100%;
                height: auto;
            }

            /* Slider Navigation */
            .slider-nav {
                display: flex;
                gap: 10px;
            }

            .articles-slider-prev,
            .articles-slider-next {
                position: static;
                width: 32px;
                height: 32px;
                background: #333;
                border-radius: 50%;
                color: #fff;

                display: flex;
                align-items: center;
                justify-content: center;

                font-size: 16px;
                /* icon size */
            }

            .global-nav {
                position: absolute;
                top: 40px;
                right: 0;
                display: flex;
                gap: 10px;
                z-index: 10;
            }



            .articles-slider-prev:hover,
            .articles-slider-next:hover {
                background: #e3120b;
                transition: all 0.3s ease;
            }

            .articles-slider-prev::after,
            .articles-slider-next::after {
                content: '';
            }

            /* Pagination */
            .articles-slider-pagination {
                position: relative;
                bottom: auto;
                margin-top: 20px;
            }

            .articles-slider-pagination .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
                margin: 0 5px;
                background: #ccc;
                opacity: 1;
                transition: all 0.3s ease;
            }

            .articles-slider-pagination .swiper-pagination-bullet-active {
                background: #e3120b;
                width: 30px;
                border-radius: 5px;
            }

            /* Category Header Block */
            .category-header-block {
                padding: 20px 0 15px 0;
                border-bottom: 1px solid var(--rs-border-primary);
                margin-bottom: 20px;
            }

            .category-header-title {
                font-size: 16px;
                font-weight: 700;
                color: #111;
                margin: 0;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Clean News List Item */
            .news-clean-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 25px;
                padding: 25px 0;
            }

            .news-clean-content {
                flex: 1;
            }

            /* Category */
            .news-category {
                font-size: 11px;
                font-weight: 600;
                color: #e3120b;
                margin-bottom: 3px;
            }

            /* Title */
            .news-title {
                font-size: 20px;
            }

            /* Image */
            .news-thumb {
                width: 180px;
                height: 120px;
                flex-shrink: 0;
                overflow: hidden;
            }

            .news-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .rs-grid-divider-4>div {
                position: relative;
                border-bottom: 1px solid var(--rs-border-primary);
            }

            /* remove bottom border from last row */
            .rs-grid-divider-4>div:nth-last-child(-n+2) {
                border-bottom: none;
            }

            /* SHORT vertical divider (only between left items) */
            .rs-grid-divider-4>div:nth-child(odd)::after {
                content: "";
                position: absolute;
                top: 20px;
                bottom: 20px;
                right: 0;
                width: 1px;
                background: var(--rs-border-primary);
            }

            @media (max-width: 1200px) {
                .news-clean-item {
                    flex-direction: column-reverse;
                    align-items: flex-start;
                    gap: 8px;
                }

                .news-thumb {
                    width: 100%;
                    height: 100%;
                }
            }

            @media (max-width: 768px) {
                .news-title {
                    font-size: 19px;
                }

                .global-nav {
                    top: 30px;
                }

                .category-header-title {
                    font-size: 14px;
                }

                .category-header-block {
                    padding: 15px 0 10px 0;
                    margin-bottom: 15px;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const slider = document.querySelector('.rs-all-articles-slider');

                if (slider) {
                    const swiper = new Swiper(slider, {
                        slidesPerView: 1,
                        spaceBetween: 20,
                        autoHeight: true, // ✅ IMPORTANT FIX

                        navigation: {
                            nextEl: slider.querySelector('.articles-slider-next'),
                            prevEl: slider.querySelector('.articles-slider-prev'),
                        },
                        pagination: {
                            el: slider.querySelector('.articles-slider-pagination'),
                            clickable: true,
                        },
                        loop: true,
                        // autoplay: {
                        //     delay: 5000,
                        //     disableOnInteraction: false,
                        // },
                    });

                    // ✅ Pause on hover
                    // slider.addEventListener('mouseenter', () => {
                    //     swiper.autoplay.stop();
                    // });

                    // slider.addEventListener('mouseleave', () => {
                    //     swiper.autoplay.start();
                    // });
                }
            });
        </script>
    </section>

    <!-- SECTION 5: DA Video section  -->
    @if(!empty($featuredVideos) && $featuredVideos->count() > 0)
        @include('components.da-video-section')
    @endif

    <!-- SECTION 6: Politics section -->
    <section class="rs-trending-stories-area rs-trending-stories-one secondary-bg" style="padding: 30px 0;">
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-9 col-lg-9">
                    <div class="section-title-space title-view-all">
                        <div class="">

                            <div class="section-title-wrapper">
                                <h2 class="section-title is-black">
                                    {{ $politicsCategory->name ?? 'Politics' }}
                                </h2>
                            </div>
                        </div>
                        <div class="">
                            <div class="section-btn">
                                <a class="rs-btn has-text has-icon"
                                    href="{{ route('category.show', $politicsCategory->slug ?? 'politics') }}">View All
                                    <span class="icon-box">
                                        <svg class="icon-first" width="17" height="12" viewBox="0 0 17 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                                fill="#121213" />
                                        </svg>
                                        <svg class="icon-second" width="17" height="12" viewBox="0 0 17 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                                fill="#121213" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="rs-post-medium rs-post-medium-one">

                            @for($i = 0; $i < 7; $i++)
                                @if(isset($politicsSectionArticles[$i]))
                                    @php $article = $politicsSectionArticles[$i]; @endphp
                                    <div class="rs-post-medium-item" style="padding-bottom: 10px;">
                                        <div class="rs-post-medium-thumb" style="border-radius:3px;">
                                            <a href="{{ route('news.show', $article->slug) }}" style="height: 100%;">
                                                <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                                    alt="{{ $article->title }}"
                                                    style="height: 100%; width: 100%; object-fit: cover;">
                                            </a>
                                        </div>
                                        <div class="rs-post-medium-content">
                                            <div class="rs-post-medium-top">
                                                <div class="news-category">
                                                    {{ $article->category->name ?? 'News' }}
                                                </div>
                                                <h5 class="rs-post-medium-title underline" style="margin: 0;">
                                                    <a href="{{ route('news.show', $article->slug) }}">
                                                        {{ \Illuminate\Support\Str::limit($article->title, 75) }}
                                                    </a>
                                                </h5>
                                                <p class="rs-post-description"
                                                    style="margin-bottom: 10px; margin-top:5px; line-height: 1.5;">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?? $article->content), 135) }}
                                                </p>
                                            </div>
                                            <div class="rs-post-medium-bottom">
                                                <div class="rs-post-meta">
                                                    <ul>
                                                        @if(!empty($article->auther))
                                                            <li>
                                                                <span class="rs-meta">
                                                                    By <a href="javascript:void(0)" class="meta-author">
                                                                        {{ $article->auther }}
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <span class="rs-meta">
                                                                <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M4.33447 3.8335C4.06114 3.8335 3.83447 3.60683 3.83447 3.3335V1.3335C3.83447 1.06016 4.06114 0.833496 4.33447 0.833496C4.60781 0.833496 4.83447 1.06016 4.83447 1.3335V3.3335C4.83447 3.60683 4.60781 3.8335 4.33447 3.8335ZM9.66781 3.8335C9.39447 3.8335 9.16781 3.60683 9.16781 3.3335V1.3335C9.16781 1.06016 9.39447 0.833496 9.66781 0.833496C9.94114 0.833496 10.1678 1.06016 10.1678 1.3335V3.3335C10.1678 3.60683 9.94114 3.8335 9.66781 3.8335ZM4.66781 9.66683C4.58114 9.66683 4.49447 9.64683 4.41447 9.6135C4.32781 9.58016 4.26114 9.5335 4.19447 9.4735C4.07447 9.34683 4.00114 9.18016 4.00114 9.00016C4.00114 8.9135 4.02114 8.82683 4.05447 8.74683C4.08781 8.66683 4.13447 8.5935 4.19447 8.52683C4.26114 8.46683 4.32781 8.42016 4.41447 8.38683C4.65447 8.28683 4.95447 8.34016 5.14114 8.52683C5.26114 8.6535 5.33447 8.82683 5.33447 9.00016C5.33447 9.04016 5.32781 9.08683 5.32114 9.1335C5.31447 9.1735 5.30114 9.2135 5.28114 9.2535C5.26781 9.2935 5.24781 9.3335 5.22114 9.3735C5.20114 9.40683 5.16781 9.44016 5.14114 9.4735C5.01447 9.5935 4.84114 9.66683 4.66781 9.66683ZM7.00114 9.66683C6.91447 9.66683 6.82781 9.64683 6.74781 9.6135C6.66114 9.58016 6.59447 9.5335 6.52781 9.4735C6.40781 9.34683 6.33447 9.18016 6.33447 9.00016C6.33447 8.9135 6.35447 8.82683 6.38781 8.74683C6.42114 8.66683 6.46781 8.5935 6.52781 8.52683C6.59447 8.46683 6.66114 8.42016 6.74781 8.38683C6.98781 8.28016 7.28781 8.34016 7.47447 8.52683C7.59447 8.6535 7.66781 8.82683 7.66781 9.00016C7.66781 9.04016 7.66114 9.08683 7.65447 9.1335C7.64781 9.1735 7.63447 9.2135 7.61447 9.2535C7.60114 9.2935 7.58114 9.3335 7.55447 9.3735C7.53447 9.40683 7.50114 9.44016 7.47447 9.4735C7.34781 9.5935 7.17447 9.66683 7.00114 9.66683ZM9.33447 9.66683C9.24781 9.66683 9.16114 9.64683 9.08114 9.6135C8.99447 9.58016 8.92781 9.5335 8.86114 9.4735L8.78114 9.3735C8.75589 9.33635 8.73571 9.29599 8.72114 9.2535C8.70188 9.21572 8.6884 9.17527 8.68114 9.1335C8.67447 9.08683 8.66781 9.04016 8.66781 9.00016C8.66781 8.82683 8.74114 8.6535 8.86114 8.52683C8.92781 8.46683 8.99447 8.42016 9.08114 8.38683C9.32781 8.28016 9.62114 8.34016 9.80781 8.52683C9.92781 8.6535 10.0011 8.82683 10.0011 9.00016C10.0011 9.04016 9.99447 9.08683 9.98781 9.1335C9.98114 9.1735 9.96781 9.2135 9.94781 9.2535C9.93447 9.2935 9.91447 9.3335 9.88781 9.3735C9.86781 9.40683 9.83447 9.44016 9.80781 9.4735C9.68114 9.5935 9.50781 9.66683 9.33447 9.66683ZM4.66781 12.0002C4.58114 12.0002 4.49447 11.9802 4.41447 11.9468C4.33447 11.9135 4.26114 11.8668 4.19447 11.8068C4.07447 11.6802 4.00114 11.5068 4.00114 11.3335C4.00114 11.2468 4.02114 11.1602 4.05447 11.0802C4.08781 10.9935 4.13447 10.9202 4.19447 10.8602C4.44114 10.6135 4.89447 10.6135 5.14114 10.8602C5.26114 10.9868 5.33447 11.1602 5.33447 11.3335C5.33447 11.5068 5.26114 11.6802 5.14114 11.8068C5.01447 11.9268 4.84114 12.0002 4.66781 12.0002ZM7.00114 12.0002C6.82781 12.0002 6.65447 11.9268 6.52781 11.8068C6.40781 11.6802 6.33447 11.5068 6.33447 11.3335C6.33447 11.2468 6.35447 11.1602 6.38781 11.0802C6.42114 10.9935 6.46781 10.9202 6.52781 10.8602C6.77447 10.6135 7.22781 10.6135 7.47447 10.8602C7.53447 10.9202 7.58114 10.9935 7.61447 11.0802C7.64781 11.1602 7.66781 11.2468 7.66781 11.3335C7.66781 11.5068 7.59447 11.6802 7.47447 11.8068C7.34781 11.9268 7.17447 12.0002 7.00114 12.0002ZM9.33447 12.0002C9.16114 12.0002 8.98781 11.9268 8.86114 11.8068C8.79945 11.7442 8.75174 11.6692 8.72114 11.5868C8.68781 11.5068 8.66781 11.4202 8.66781 11.3335C8.66781 11.2468 8.68781 11.1602 8.72114 11.0802C8.75447 10.9935 8.80114 10.9202 8.86114 10.8602C9.01447 10.7068 9.24781 10.6335 9.46114 10.6802C9.50781 10.6868 9.54781 10.7002 9.58781 10.7202C9.62781 10.7335 9.66781 10.7535 9.70781 10.7802C9.74114 10.8002 9.77447 10.8335 9.80781 10.8602C9.92781 10.9868 10.0011 11.1602 10.0011 11.3335C10.0011 11.5068 9.92781 11.6802 9.80781 11.8068C9.68114 11.9268 9.50781 12.0002 9.33447 12.0002ZM12.6678 6.56016H1.33447C1.06114 6.56016 0.834473 6.3335 0.834473 6.06016C0.834473 5.78683 1.06114 5.56016 1.33447 5.56016H12.6678C12.9411 5.56016 13.1678 5.78683 13.1678 6.06016C13.1678 6.3335 12.9411 6.56016 12.6678 6.56016Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M9.66667 15.1668H4.33333C1.9 15.1668 0.5 13.7668 0.5 11.3335V5.66683C0.5 3.2335 1.9 1.8335 4.33333 1.8335H9.66667C12.1 1.8335 13.5 3.2335 13.5 5.66683V11.3335C13.5 13.7668 12.1 15.1668 9.66667 15.1668ZM4.33333 2.8335C2.42667 2.8335 1.5 3.76016 1.5 5.66683V11.3335C1.5 13.2402 2.42667 14.1668 4.33333 14.1668H9.66667C11.5733 14.1668 12.5 13.2402 12.5 11.3335V5.66683C12.5 3.76016 11.5733 2.8335 9.66667 2.8335H4.33333Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                                <span>{{ $article->published_at ? $article->published_at->format('F Y') : '' }}</span>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </div>

                        <div class="rs-trending-stories-btn text-center mt-40">
                            <a class="rs-btn has-icon has-bg-white"
                                href="{{ route('category.show', $politicsCategory->slug ?? 'politics') }}">Load More News
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.25 8C1.25 8.14918 1.19074 8.29226 1.08525 8.39775C0.979758 8.50324 0.836684 8.5625 0.6875 8.5625C0.538316 8.5625 0.395242 8.50324 0.289752 8.39775C0.184263 8.29226 0.125 8.14918 0.125 8C0.125 3.65764 3.65764 0.125 8 0.125C10.1644 0.125 12.167 0.987453 13.625 2.47245V0.6875C13.625 0.538316 13.6843 0.395242 13.7898 0.289752C13.8952 0.184263 14.0383 0.125 14.1875 0.125C14.3367 0.125 14.4798 0.184263 14.5852 0.289752C14.6907 0.395242 14.75 0.538316 14.75 0.6875V4.0625C14.75 4.21168 14.6907 4.35476 14.5852 4.46025C14.4798 4.56574 14.3367 4.625 14.1875 4.625H10.8125C10.6633 4.625 10.5202 4.56574 10.4148 4.46025C10.3093 4.35476 10.25 4.21168 10.25 4.0625C10.25 3.91332 10.3093 3.77024 10.4148 3.66475C10.5202 3.55926 10.6633 3.5 10.8125 3.5H13.0496C11.7875 2.08025 9.97184 1.25 8 1.25C4.27808 1.25 1.25 4.27808 1.25 8ZM15.3125 7.4375C15.1633 7.4375 15.0202 7.49676 14.9148 7.60225C14.8093 7.70774 14.75 7.85082 14.75 8C14.75 11.7219 11.7219 14.75 8 14.75C6.02816 14.75 4.21255 13.9197 2.95044 12.5H5.1875C5.33668 12.5 5.47976 12.4407 5.58525 12.3352C5.69074 12.2298 5.75 12.0867 5.75 11.9375C5.75 11.7883 5.69074 11.6452 5.58525 11.5398C5.47976 11.4343 5.33668 11.375 5.1875 11.375H1.8125C1.66332 11.375 1.52024 11.4343 1.41475 11.5398C1.30926 11.6452 1.25 11.7883 1.25 11.9375V15.3125C1.25 15.4617 1.30926 15.6048 1.41475 15.7102C1.52024 15.8157 1.66332 15.875 1.8125 15.875C1.96168 15.875 2.10476 15.8157 2.21025 15.7102C2.31574 15.6048 2.375 15.4617 2.375 15.3125V13.5275C3.833 15.0125 5.83564 15.875 8 15.875C12.3424 15.875 15.875 12.3424 15.875 8C15.875 7.85082 15.8157 7.70774 15.7102 7.60225C15.6048 7.49676 15.4617 7.4375 15.3125 7.4375Z"
                                        fill="#121213" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>

                {{-- Right: Advertisement --}}
                <div class="col-xl-3 col-lg-3">
                    <x-advertisement-box width="100%" height="100%" style="min-height: 300px;" />
                </div>
            </div>
        </div>
        <style>
            @media only screen and (max-width: 767px) {
                .rs-post-medium-one .rs-post-medium-item {
                    gap: 5px !important;
                    margin-bottom: 25px !important;
                }
            }
        </style>
    </section>

    <!-- SECTION 7: Business section -->
    <section class="rs-trending-news-area rs-trending-news-three" style="padding: 30px 0;">
        <div class="container">
            <div class="section-title-space title-view-all">
                <div class="">
                    <div class="section-title-wrapper">
                        <h2 class="section-title">
                            {{ $businessCategory->name ?? 'Business' }}
                        </h2>
                    </div>
                </div>
                <div class="">
                    <div class="section-btn d-flex justify-content-lg-end">
                        <a class="rs-btn has-text has-icon" href="{{ route('category.show', 'business') }}">View All
                            <span class="icon-box">
                                <svg class="icon-first" width="17" height="12" viewBox="0 0 17 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                        fill="#121213" />
                                </svg>
                                <svg class="icon-second" width="17" height="12" viewBox="0 0 17 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                        fill="#121213" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            @if(isset($businessArticles[0]))
                <div class="row g-5">
                    <div class="{{ count($businessArticles) > 1 ? 'col-xl-4' : 'col-xl-12' }}">
                        <div style="height: 100%;" class="rs-post-overlay rs-post-overlay-one featured-category-post">
                            <a href="{{ route('news.show', $businessArticles[0]->slug) }}">
                                <div class="rs-post-overlay-bg-thumb"
                                    data-background="{{ $businessArticles[0]->featured_image ? asset('storage/' . $businessArticles[0]->featured_image) : asset('assets/images/default/news-placeholder.webp') }}">
                                </div>
                            </a>

                            <div class="rs-post-overlay-content">

                                <h5 class="rs-post-overlay-title is-white underline">
                                    <a href="{{ route('news.show', $businessArticles[0]->slug) }}">
                                        {{ \Illuminate\Support\Str::limit($businessArticles[0]->title, 55) }}
                                    </a>
                                </h5>

                                <div class="rs-post-meta meta-white">
                                    <ul>
                                        @if(!empty($businessArticles[0]->auther))
                                            <li>
                                                <span class="rs-meta">
                                                    By <a href="javascript:void(0)" class="meta-author">
                                                        {{ $businessArticles[0]->auther }}
                                                    </a>
                                                </span>
                                            </li>
                                        @endif
                                        <li>
                                            <span class="rs-meta">
                                                <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.33447 3.8335C4.06114 3.8335 3.83447 3.60683 3.83447 3.3335V1.3335C3.83447 1.06016 4.06114 0.833496 4.33447 0.833496C4.60781 0.833496 4.83447 1.06016 4.83447 1.3335V3.3335C4.83447 3.60683 4.60781 3.8335 4.33447 3.8335ZM9.66781 3.8335C9.39447 3.8335 9.16781 3.60683 9.16781 3.3335V1.3335C9.16781 1.06016 9.39447 0.833496 9.66781 0.833496C9.94114 0.833496 10.1678 1.06016 10.1678 1.3335V3.3335C10.1678 3.60683 9.94114 3.8335 9.66781 3.8335ZM12.6678 6.56016H1.33447C1.06114 6.56016 0.834473 6.3335 0.834473 6.06016C0.834473 5.78683 1.06114 5.56016 1.33447 5.56016H12.6678C12.9411 5.56016 13.1678 5.78683 13.1678 6.06016C13.1678 6.3335 12.9411 6.56016 12.6678 6.56016Z"
                                                        fill="white"></path>
                                                    <path
                                                        d="M9.66667 15.1668H4.33333C1.9 15.1668 0.5 13.7668 0.5 11.3335V5.66683C0.5 3.2335 1.9 1.8335 4.33333 1.8335H9.66667C12.1 1.8335 13.5 3.2335 13.5 5.66683V11.3335C13.5 13.7668 12.1 15.1668 9.66667 15.1668ZM4.33333 2.8335C2.42667 2.8335 1.5 3.76016 1.5 5.66683V11.3335C1.5 13.2402 2.42667 14.1668 4.33333 14.1668H9.66667C11.5733 14.1668 12.5 13.2402 12.5 11.3335V5.66683C12.5 3.76016 11.5733 2.8335 9.66667 2.8335H4.33333Z"
                                                        fill="white"></path>
                                                </svg>
                                                <span>
                                                    {{ $businessArticles[0]->published_at ? $businessArticles[0]->published_at->format('F Y') : '' }}
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(count($businessArticles) > 1)
                        <div class="col-xl-8">
                            <div class="rs-post-small-nineteen">
                                <div class="rs-post-small-wrapper">
                                    @for($i = 1; $i < 9; $i++)
                                        @if(isset($businessArticles[$i]))
                                            @php $article = $businessArticles[$i]; @endphp
                                            <div class="rs-post-small">
                                                <div class="rs-post-small-thumb" style="border-radius:3px;">
                                                    <a href="{{ route('news.show', $article->slug) }}" class="image-link">
                                                        <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                                            alt="{{ $article->title }}">
                                                    </a>
                                                </div>
                                                <div class="rs-post-small-content">
                                                    <h6 class="rs-post-small-title underline">
                                                        <a href="{{ route('news.show', $article->slug) }}">
                                                            {{ \Illuminate\Support\Str::limit($article->title, 55) }}
                                                        </a>
                                                    </h6>
                                                    @if(!empty($article->auther))
                                                        <div class="rs-post-meta">
                                                            <ul>
                                                                <li>
                                                                    <span class="rs-meta">
                                                                        By <a href="javascript:void(0)" class="meta-author">
                                                                            {{ $article->auther }}
                                                                        </a>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <style>
            /* Business Articles - Mobile 2-column grid for remaining articles */
            @media (max-width: 768px) {
                .rs-post-small-nineteen .rs-post-small-wrapper {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 15px;
                }

                .rs-post-small-nineteen .rs-post-small {
                    display: flex;
                    flex-direction: column;
                    align-items: start;
                    gap: 0px !important;
                    padding: 15px 0;
                }

                .rs-post-small-nineteen .rs-post-small-thumb {
                    width: 100%;
                    aspect-ratio: 16/10;
                    margin-bottom: 4px;
                    overflow: hidden;
                }

                .rs-post-small-nineteen .rs-post-small-thumb img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .rs-post-small-nineteen .rs-post-small-content {
                    width: 100%;
                }

                .rs-post-small-nineteen .rs-post-small-title {
                    font-size: 15px;
                    line-height: 1.3;
                }

                .rs-post-meta {
                    font-size: 10px;
                }

                .rs-post-small-nineteen .rs-post-small:nth-child(1) {
                    border-top: 1px solid var(--rs-border-primary) !important;
                    padding-top: 12px !important;
                }
            }
        </style>
    </section>

    <!-- SECTION 8: Lifestyle section -->
    <section class="rs-trending-news-area rs-lifestyle-section" style="padding: 30px 0;">
        <div class="container">
            <div class="row g-5">

                {{-- LEFT CONTENT --}}
                <div class="col-xl-9 col-lg-9">

                    {{-- TITLE --}}
                    <div class="section-title-space title-view-all">
                        <h2 class="section-title">Lifestyle</h2>

                        <div class="section-btn d-flex justify-content-lg-end">
                            <a class="rs-btn has-text has-icon" href="{{ route('category.show', 'lifestyle') }}">
                                View All
                                <span class="icon-box">
                                    <svg class="icon-first" width="17" height="12" viewBox="0 0 17 12" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                            fill="#121213" />
                                    </svg>
                                    <svg class="icon-second" width="17" height="12" viewBox="0 0 17 12" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                            fill="#121213" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>

                    @if(isset($lifestyleArticles[0]))

                        {{-- 🔥 ROW 1: 2 FEATURED CARDS --}}
                        <div class="row g-4 mb-4">

                            @for($i = 0; $i <= 1; $i++)
                                @if(isset($lifestyleArticles[$i]))
                                    <div class="col-md-6">
                                        <div class="lifestyle-card">

                                            {{-- IMAGE --}}
                                            <div class="lifestyle-thumb">
                                                <a href="{{ route('news.show', $lifestyleArticles[$i]->slug) }}">
                                                    <img src="{{ asset('storage/' . $lifestyleArticles[$i]->featured_image) }}">
                                                </a>
                                            </div>

                                            {{-- CONTENT --}}
                                            <div class="lifestyle-content">

                                                <h4 class="title">
                                                    <a href="{{ route('news.show', $lifestyleArticles[$i]->slug) }}">
                                                        {{ \Illuminate\Support\Str::limit($lifestyleArticles[$i]->title, 70) }}
                                                    </a>
                                                </h4>

                                                @if(!empty($lifestyleArticles[$i]->auther))
                                                    <div class="meta">
                                                        By {{ $lifestyleArticles[$i]->auther }}
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endfor

                        </div>

                        {{-- ⚡ ROW 2: 2 HORIZONTAL CARDS --}}
                        <div class="row g-4 mb-4" style="margin-top:20px;">

                            @for($i = 2; $i <= 3; $i++)
                                @if(isset($lifestyleArticles[$i]))
                                    <div class="col-md-6">
                                        <div class="lifestyle-horizontal">

                                            {{-- IMAGE --}}
                                            <div class="thumb">
                                                <a href="{{ route('news.show', $lifestyleArticles[$i]->slug) }}">
                                                    <img src="{{ asset('storage/' . $lifestyleArticles[$i]->featured_image) }}">
                                                </a>
                                            </div>

                                            {{-- CONTENT --}}
                                            <div class="content">

                                                <h5 class="title">
                                                    <a href="{{ route('news.show', $lifestyleArticles[$i]->slug) }}">
                                                        {{ \Illuminate\Support\Str::limit($lifestyleArticles[$i]->title, 55) }}
                                                    </a>
                                                </h5>

                                                @if(!empty($lifestyleArticles[$i]->auther))
                                                    <div class="meta">
                                                        By {{ $lifestyleArticles[$i]->auther }}
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endfor

                        </div>

                    @endif

                </div>

                {{-- RIGHT AD --}}
                <div class="col-xl-3 col-lg-3">
                    <x-advertisement-box width="100%" height="100%" style="min-height: 300px;" />
                </div>

            </div>
        </div>
        <style>
            /* CARD BASE */
            .lifestyle-card {
                background: #fff;
                border-radius: 6px;
                overflow: hidden;
                border: 1px solid var(--rs-border-primary);
                transition: 0.3s;
            }

            .lifestyle-card:hover {
                transform: translateY(-3px);
            }

            /* IMAGE */
            .lifestyle-thumb {
                width: 100%;
                height: 250px;
                overflow: hidden;
            }

            .lifestyle-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: 0.4s;
            }

            .lifestyle-thumb:hover img {
                transform: scale(1.05);
            }

            /* CONTENT */
            .lifestyle-content {
                padding: 12px;
            }

            .lifestyle-content .title {
                font-size: 18px;
                font-weight: 600;
                margin: 5px 0;
            }

            .lifestyle-content .meta {
                font-size: 13px;
                color: #777;
            }

            /* HORIZONTAL */
            .lifestyle-horizontal {
                display: flex;
                gap: 15px;
                border-bottom: 1px solid var(--rs-border-primary);
                padding-bottom: 10px;
            }

            .lifestyle-horizontal .thumb {
                flex: 0 0 120px;
                height: 90px;
            }

            .lifestyle-horizontal img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 6px;
            }

            .lifestyle-horizontal .content {
                flex: 1;
            }

            /* SMALL */
            .lifestyle-card.small .lifestyle-thumb {
                height: 120px;
            }

            /* MOBILE */
            @media (max-width: 768px) {

                /* TOP → SINGLE COLUMN */
                .rs-lifestyle-section .row>div {
                    width: 100%;
                }

                /* SECOND ROW → 2 PER ROW */
                .lifestyle-horizontal {
                    flex-direction: column;
                }

                .lifestyle-thumb {
                    height: 100%;
                }

                .lifestyle-horizontal .thumb {
                    width: 100%;
                    height: 100%;
                }
            }
        </style>
    </section>

    <!-- SECTION 9: Bookshelf section -->
    <section class="rs-trending-news-area rs-trending-news-three" style="padding: 30px 0;">
        <div class="container">
            <div class="row g-5">

                {{-- LEFT: Bookshelf Content --}}
                <div class="col-xl-9 col-lg-9">

                    {{-- Title + Button --}}
                    <div class="section-title-space title-view-all">
                        <div class="">
                            <div class="section-title-wrapper">
                                <h2 class="section-title">
                                    {{ $bookshelfCategory->name }}
                                </h2>
                            </div>
                        </div>

                        <div class="">
                            <div class="section-btn d-flex justify-content-lg-end">
                                <a class="rs-btn has-text has-icon"
                                    href="{{ route('category.show', $bookshelfCategory->slug) }}">
                                    View All
                                    <span class="icon-box">
                                        <svg class="icon-first" width="17" height="12" viewBox="0 0 17 12" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                                fill="#121213" />
                                        </svg>
                                        <svg class="icon-second" width="17" height="12" viewBox="0 0 17 12" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.3153 5.0991C13.1189 5.0991 11.1171 3.0991 11.1171 0.900901V0H9.31532V0.900901C9.31532 2.4991 10.0162 3.9982 11.1162 5.0991H0V6.9009H11.1162C10.0162 8.0018 9.31532 9.5009 9.31532 11.0991V12H11.1171V11.0991C11.1171 8.9018 13.1189 6.9009 15.3153 6.9009H16.2162V5.0991H15.3153Z"
                                                fill="#121213" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Articles Grid --}}
                    <div class="hide-on-mobile">
                        <div class="row g-5 justify-content-center">
                            @foreach($bookshelfArticles as $article)
                                <div class="col-xl-4 col-lg-4 col-md-6">
                                    <div class="rs-post-overlay rs-post-overlay-four"
                                        style="border-radius: 3px; height: 450px;">
                                        <a href="{{ route('news.show', $article->slug) }}">
                                            <div class="rs-post-overlay-bg-thumb"
                                                style="background-image: url('{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}'); background-position: center;">
                                            </div>
                                        </a>

                                        <div class="rs-post-overlay-content">

                                            <h5 class="rs-post-overlay-title is-white underline">
                                                <a href="{{ route('news.show', $article->slug) }}">
                                                    {{ \Illuminate\Support\Str::limit($article->title, 40) }}
                                                </a>
                                            </h5>

                                            <div class="rs-post-meta meta-white">
                                                <ul>
                                                    @if(!empty($article->auther))
                                                        <li>
                                                            <span class="rs-meta">
                                                                By <a href="javascript:void(0)" class="meta-author">
                                                                    {{ $article->auther }}
                                                                </a>
                                                            </span>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <span class="rs-meta">
                                                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4.33447 3.8335C4.06114 3.8335 3.83447 3.60683 3.83447 3.3335V1.3335C3.83447 1.06016 4.06114 0.833496 4.33447 0.833496C4.60781 0.833496 4.83447 1.06016 4.83447 1.3335V3.3335C4.83447 3.60683 4.60781 3.8335 4.33447 3.8335ZM9.66781 3.8335C9.39447 3.8335 9.16781 3.60683 9.16781 3.3335V1.3335C9.16781 1.06016 9.39447 0.833496 9.66781 0.833496C9.94114 0.833496 10.1678 1.06016 10.1678 1.3335V3.3335C10.1678 3.60683 9.94114 3.8335 9.66781 3.8335ZM12.6678 6.56016H1.33447C1.06114 6.56016 0.834473 6.3335 0.834473 6.06016C0.834473 5.78683 1.06114 5.56016 1.33447 5.56016H12.6678C12.9411 5.56016 13.1678 5.78683 13.1678 6.06016C13.1678 6.3335 12.9411 6.56016 12.6678 6.56016Z"
                                                                    fill="white"></path>
                                                                <path
                                                                    d="M9.66667 15.1668H4.33333C1.9 15.1668 0.5 13.7668 0.5 11.3335V5.66683C0.5 3.2335 1.9 1.8335 4.33333 1.8335H9.66667C12.1 1.8335 13.5 3.2335 13.5 5.66683V11.3335C13.5 13.7668 12.1 15.1668 9.66667 15.1668ZM4.33333 2.8335C2.42667 2.8335 1.5 3.76016 1.5 5.66683V11.3335C1.5 13.2402 2.42667 14.1668 4.33333 14.1668H9.66667C11.5733 14.1668 12.5 13.2402 12.5 11.3335V5.66683C12.5 3.76016 11.5733 2.8335 9.66667 2.8335H4.33333Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                            <span>{{ optional($article->published_at)->format('F Y') }}</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="hide-on-desktop">
                        <div class="swiper rs-bookshelf-slider">
                            <div class="swiper-wrapper">
                                @foreach($bookshelfArticles as $article)
                                    <div class="swiper-slide">
                                        <div class="rs-post-overlay rs-post-overlay-four"
                                            style="border-radius: 3px; height: 400px;">
                                            <a href="{{ route('news.show', $article->slug) }}">
                                                <div class="rs-post-overlay-bg-thumb"
                                                    style="background-image: url('{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}'); background-position: center;">
                                                </div>
                                            </a>

                                            <div class="rs-post-overlay-content">
                                                <h5 class="rs-post-overlay-title is-white underline">
                                                    <a href="{{ route('news.show', $article->slug) }}">
                                                        {{ \Illuminate\Support\Str::limit($article->title, 40) }}
                                                    </a>
                                                </h5>

                                                <div class="rs-post-meta meta-white">
                                                    <ul>
                                                        @if(!empty($article->auther))
                                                            <li>
                                                                <span class="rs-meta">
                                                                    By <a href="javascript:void(0)" class="meta-author">
                                                                        {{ $article->auther }}
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-pagination bookshelf-slider-pagination"></div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT: Advertisement --}}
                <div class="col-xl-3 col-lg-3">
                    <x-advertisement-box width="100%" height="100%" style="min-height: 300px;" />
                </div>

            </div>
        </div>
        <style>
            /* Bookshelf Mobile Slider */
            .rs-bookshelf-slider {
                position: relative;
            }

            .rs-bookshelf-slider .swiper-wrapper {
                display: flex;
            }

            .rs-bookshelf-slider .swiper-slide {
                width: 100%;
                height: auto;
            }

            /* Pagination */
            .bookshelf-slider-pagination {
                position: relative;
                bottom: auto;
                margin-top: 20px;
            }

            .bookshelf-slider-pagination .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
                margin: 0 5px;
                background: #ccc;
                opacity: 1;
                transition: all 0.3s ease;
            }

            .bookshelf-slider-pagination .swiper-pagination-bullet-active {
                background: #e3120b;
                width: 30px;
                border-radius: 5px;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const bookshelfSlider = document.querySelector('.rs-bookshelf-slider');

                if (bookshelfSlider) {
                    const swiper = new Swiper(bookshelfSlider, {
                        slidesPerView: 1,
                        spaceBetween: 20,
                        autoHeight: true,

                        navigation: {
                            nextEl: bookshelfSlider.querySelector('.bookshelf-slider-next'),
                            prevEl: bookshelfSlider.querySelector('.bookshelf-slider-prev'),
                        },
                        pagination: {
                            el: bookshelfSlider.querySelector('.bookshelf-slider-pagination'),
                            clickable: true,
                        },
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                    });

                    bookshelfSlider.addEventListener('mouseenter', () => {
                        swiper.autoplay.stop();
                    });

                    bookshelfSlider.addEventListener('mouseleave', () => {
                        swiper.autoplay.start();
                    });
                }
            });
        </script>
    </section>

@endsection