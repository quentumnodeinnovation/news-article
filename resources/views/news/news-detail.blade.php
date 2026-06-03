@extends('layouts.app')

@section('title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: $article->excerpt)

@section('og_type', 'article')

@section('og_title', $article->title)

@section(
    'og_description',
    $article->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($article->content), 150)
)

@section('og_url', url()->current())

@php
    // ✅ Safe image handling (NO controller needed)

    $defaultImage = asset('assets/images/default/news-placeholder.jpg'); // changed to JPG

    $imagePath = $article->featured_image
        ? public_path('storage/' . $article->featured_image)
        : null;

    $imageUrl = ($article->featured_image && file_exists($imagePath))
        ? asset('storage/' . $article->featured_image)
        : $defaultImage;

    // ✅ Cache busting (forces Facebook to refresh)
    $imageUrl = $imageUrl . '?v=' . time();
@endphp

@section('og_image', $imageUrl)

@section('content')

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;0,900;1,400&family=Source+Sans+3:wght@400;500;600;700&display=swap');

            :root {
                --rs-theme-primary: #0d6efd;
                --rs-theme-red: #da2128;
                --rs-text-serif: 'Merriweather', serif;
                --rs-text-sans: 'Source Sans 3', sans-serif;
                --rs-title-primary: #10171e;
                --rs-body-text: #4b5563;
            }

            #rsReadingProgress {
                position: fixed;
                top: 0;
                left: 0;
                width: 0%;
                height: 4px;
                background: var(--rs-theme-red);
                z-index: 9999;
                transition: width 0.1s ease;
            }

            .rs-breadcrumb-two {
                padding: 30px 0;
                background: #f8fafc;
                border-bottom: 1px solid #eef2f6;
            }

            .rs-breadcumb-item {
                font-family: var(--rs-text-sans);
                font-size: 14px;
                color: #64748b;
            }

            .rs-breadcumb-item a {
                color: var(--rs-title-primary);
                font-weight: 600;
                transition: color 0.3s;
            }

            .rs-breadcumb-item a:hover {
                color: var(--rs-theme-red);
            }

            .rs-blog-post-area {
                padding-top: 30px;
            }

            .rs-article-header {
                position: relative;
                margin-bottom: 20px;
            }

            .rs-category-badge {
                position: absolute;
                top: 0;
                right: 0;
                background: var(--rs-theme-red);
                color: #fff;
                padding: 6px 16px;
                font-family: var(--rs-text-sans);
                font-weight: 700;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                z-index: 2;
            }

            .rs-blog-post-title {
                font-family: var(--rs-text-serif);
                font-weight: 700;
                font-size: 42px;
                line-height: 1.2;
                color: var(--rs-title-primary);
                max-width: 900px;
                margin-bottom: 15px;
                text-align: left;
            }

            .rs-post-meta-row {
                display: flex;
                width: 100%;
                font-family: var(--rs-text-serif);
                align-items: center;
                justify-content: space-between;
                gap: 24px;
                border-bottom: 1px solid #f1f5f9;
                flex-wrap: wrap;
                background: #989898;
                margin-bottom: 25px;
                padding: 12px 5px;
            }

            .rs-post-meta-row p {
                font-size: 25px;
                color: white !important;
                font-weight: 600;
                font-family: var(--rs-text-serif);
                margin-bottom: 0 !important;
            }

            .rs-post-meta-row span {
                font-size: 15px;
                font-family: var(--rs-text-serif);
                color: white;
            }

            .rs-meta-item {
                display: flex;
                align-items: center;
                gap: 8px;
                font-family: var(--rs-text-sans);
                font-size: 14px;
                color: #64748b;
                font-weight: 500;
            }

            .rs-meta-item i,
            .rs-meta-item svg {
                color: var(--rs-theme-primary);
            }

            .rs-meta-author-img {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                object-fit: cover;
            }

            .rs-meta-link {
                color: var(--rs-title-primary);
                font-weight: 700;
                text-decoration: none;
                transition: color 0.2s;
            }

            .rs-meta-link:hover {
                color: var(--rs-theme-red);
            }

            .rs-featured-img-container {
                margin-bottom: 0;
            }

            .rs-featured-img-container img {
                width: 100%;
                border-radius: 4px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }

            .article-body-content {
                font-family: var(--rs-text-serif) !important;
                color: var(--rs-title-primary) !important;
                font-size: 19px;
                line-height: 1.8;
                color: var(--rs-body-text);
            }

            .article-body-content p {
                font-family: var(--rs-text-serif) !important;
                color: var(--rs-title-primary) !important;
                margin-bottom: 18px;
                line-height: 25px !important;
            }

            .article-body-content h1 {
                font-family: var(--rs-text-serif) !important;
            }
            .article-body-content h2 {
                font-family: var(--rs-text-serif) !important;
            }
            .article-body-content h3 {
                font-family: var(--rs-text-serif) !important;
            }
            .article-body-content h4 {
                font-family: var(--rs-text-serif) !important;
            }
            .article-body-content h5 {
                font-family: var(--rs-text-serif) !important;
            }
            .article-body-content h6 {
                font-family: var(--rs-text-serif) !important;
            }

            .article-body-content blockquote {
                position: relative;
                padding: 40px;
                background: #fdf2f2;
                border-left: 4px solid var(--rs-theme-red);
                margin: 45px 0;
                font-style: italic;
                font-size: 22px;
                color: var(--rs-title-primary);
                border-radius: 0 8px 8px 0;
            }

            .article-body-content blockquote::before {
                content: '"';
                position: absolute;
                top: 10px;
                left: 20px;
                font-size: 100px;
                font-family: Georgia, serif;
                color: rgba(218, 33, 40, 0.1);
                line-height: 1;
            }

            .rs-content-list {
                list-style: none;
                padding-left: 0;
                margin: 30px 0;
            }

            .rs-content-list li {
                position: relative;
                padding-left: 35px;
                margin-bottom: 15px;
                font-family: var(--rs-text-sans);
                font-weight: 500;
                font-size: 17px;
            }

            .rs-content-list li::before {
                content: '\2713';
                position: absolute;
                left: 0;
                top: 0;
                width: 24px;
                height: 24px;
                background: var(--rs-theme-primary);
                color: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                font-weight: bold;
            }

            /* Paywall Styles */
            .rs-paywall-preview {
                position: relative;
            }

            .rs-paywall-gradient {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 250px;
                background: linear-gradient(to top, #fff, transparent);
                z-index: 5;
            }

            .rs-subscribe-cta {
                margin-top: -60px;
                padding: 50px;
                background: #111827;
                color: #fff;
                border-radius: 12px;
                text-align: center;
                position: relative;
                z-index: 10;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .rs-subscribe-cta h3 {
                color: #fff;
                font-family: var(--rs-text-serif);
                font-size: 28px;
                margin-bottom: 15px;
            }

            .rs-subscribe-cta p {
                color: #9ca3af;
                margin-bottom: 30px;
                font-family: var(--rs-text-sans);
            }

            .rs-subscribe-btn {
                background: var(--rs-theme-red);
                color: #fff;
                padding: 14px 40px;
                border-radius: 99px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
                text-decoration: none;
                transition: transform 0.3s, background 0.3s;
                display: inline-block;
            }

            .rs-subscribe-btn:hover {
                background: #bc1921;
                transform: translateY(-3px);
                color: #fff;
            }

            /* Author Box */
            .rs-author-box {
                display: flex;
                gap: 30px;
                padding: 20px;
                background: #f8fafc;
                border-radius: 12px;
                margin-top: 60px;
                align-items: center;
            }

            .rs-author-box img {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                object-fit: cover;
            }

            .rs-author-info h4 {
                font-family: var(--rs-text-serif);
                margin-bottom: 10px;
                color: var(--rs-title-primary);
            }

            .rs-author-info p {
                font-family: var(--rs-text-sans);
                color: #64748b;
                font-size: 15px;
                line-height: 1.6;
                margin: 0;
            }

            .rs-related-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
                margin-top: 30px;
            }

            .rs-related-card {
                text-decoration: none;
                group: hover;
            }

            .rs-related-thumb {
                width: 100%;
                height: 180px;
                border-radius: 8px;
                overflow: hidden;
                margin-bottom: 15px;
            }

            .rs-related-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s;
            }

            .rs-related-card:hover .rs-related-thumb img {
                transform: scale(1.08);
            }

            .rs-related-card h6 {
                font-family: var(--rs-text-sans);
                font-weight: 700;
                line-height: 1.4;
                color: var(--rs-title-primary);
                transition: color 0.3s;
            }

            .rs-related-card:hover h6 {
                color: var(--rs-theme-red);
            }

            .right-text {
                margin-left: auto;
            }

            @media (max-width: 768px) {
                .rs-blog-post-title {
                    font-size: 32px;
                }

                .rs-related-grid {
                    grid-template-columns: 1fr;
                }

                .rs-author-box {
                    flex-direction: column;
                    text-align: center;
                }
            }

            .article-content p:first-of-type::first-letter {
                font-size: 55px;
                font-weight: 700;
                float: left;
                line-height: 0.8;
                margin-right: 5px;
                margin-top: 3px;
            }

            .article-share-box {
                display: flex;
                align-items: center;
                gap: 10px;
                margin: 25px 0;
            }

            .share-label {
                font-weight: 600;
                margin-right: 8px;
            }

            .share-icon {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                color: #fff;
                text-decoration: none;
                border: none;
                cursor: pointer;
                transition: 0.3s;
            }

            .share-icon:hover {
                transform: translateY(-3px);
                color: white;
            }

            .whatsapp {
                background: #25D366;
            }

            .linkedin {
                background: #0077B5;
            }

            .twitter {
                background: #000;
            }

            .facebook {
                background: #1877F2;
            }

            .copy {
                background: #555;
            }
        </style>

        <div id="rsReadingProgress"></div>

        <!-- breadcrumb area start -->
        <div class="rs-breadcrumb-area rs-breadcrumb-two p-relative section-space">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-8 col-xl-8 col-lg-9">
                        <div class="rs-breadcrumb-wrapper">
                            <div class="rs-breadcrumb-menu">
                                <nav>
                                    <ul>
                                        <li class="rs-breadcumb-item">
                                            <span>
                                                <a href="{{ route('home') }}">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M15.4125 6.1124L9.69686 1.3249C8.71561 0.503027 7.28436 0.503027 6.30311 1.3249L0.587484 6.1124C-0.106266 6.69365 -0.196891 7.72803 0.384359 8.41865C0.671859 8.7624 1.08748 8.97178 1.53123 8.9999V13.6562C1.53123 14.5562 2.26248 15.2874 3.16561 15.2905H6.67811V11.2593C6.67811 10.5312 7.26873 9.94053 7.99686 9.94053C8.72498 9.94053 9.31561 10.5312 9.31561 11.2593V15.2937H12.8312C13.7312 15.2937 14.4625 14.5624 14.4656 13.6593V9.00303C15.3687 8.94365 16.0531 8.1624 15.9937 7.25928C15.9625 6.81553 15.7531 6.3999 15.4125 6.1124Z"
                                                            fill="black" />
                                                    </svg>
                                                    Home
                                                </a>
                                            </span>
                                        </li>
                                        <!-- @if($article->category)
                                                                                                                                                            <li class="rs-breadcumb-item">
                                                                                                                                                                <span>
                                                                                                                                                                    <a href="{{ route('category.show', $article->category->slug) }}">
                                                                                                                                                                    {{ $article->category->name }}
                                                                                                                                                                </a>
                                                                                                                                                                </span>
                                                                                                                                                            </li>
                                                                                                                                                        @endif -->
                                        <li class="rs-breadcumb-item">
                                            {{ \Illuminate\Support\Str::limit($article->title, 40) }}
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- blog post area start -->
        <section class="rs-blog-post-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">

                    </div>
                </div>

                <div class="row g-5" style="padding-bottom: 30px;">
                    <div class="col-xl-8 col-lg-8">
                        <div class="rs-postbox-details-content">

                            @php
$shareUrl = urlencode(url()->current());
$shareTitle = urlencode($article->title);

$canRead = auth()->check();
// Future logic
// $canRead = auth()->check() && auth()->user()->canReadFullArticles();

$cleanContent = $article->content;

$cleanContent = preg_replace('#\sstyle=("|\')(.*?)\1#i', '', $cleanContent);
$cleanContent = preg_replace('#</?(span|font)[^>]*>#i', '', $cleanContent);
$cleanContent = preg_replace('#\s(width|height|align|class)=("|\')(.*?)\2#i', '', $cleanContent);

$paragraphs = explode('</p>', $cleanContent);

$preview = collect($paragraphs)->take(2)->implode('</p>');
$remaining = collect($paragraphs)->slice(2)->implode('</p>');

// $preview = \Illuminate\Support\Str::limit($cleanContent, 550);
// $remaining = str_replace($preview, '', $cleanContent);
                            @endphp
                            <div class="rs-article-header">

                            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;">
                                <div class="article-share-box">

                                    <span style="font-size: 20px; color: black; font-weight: bold;">Share on:</span>

                                    <!-- WhatsApp -->
                                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" class="share-icon whatsapp"
                                        title="Share on WhatsApp">
                                        <i class="ri-whatsapp-fill"></i>
                                    </a>

                                    <!-- LinkedIn -->
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank"
                                        class="share-icon linkedin" title="Share on LinkedIn">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>

                                    <!-- Twitter / X -->
                                    <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" target="_blank"
                                        class="share-icon twitter" title="Share on X">
                                        <i class="ri-twitter-x-fill"></i>
                                    </a>

                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="share-icon facebook"
                                        title="Share on Facebook">
                                        <i class="ri-facebook-fill"></i>
                                    </a>

                                    <!-- Copy Link -->
                                    <button onclick="copyArticleLink()" class="share-icon copy" title="Copy Link">
                                        <i class="ri-link"></i>
                                    </button>

                                </div>
                                @if($article->pdf_file)
                                    <p class="right-text">
                                        <span style="font-size: 20px; color: black; font-weight: bold;"> Source: </span>
                                        <a class="rs-btn has-text has-icon" href="{{ asset('storage/' . $article->pdf_file) }}"
                                            target="_blank">View
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
                                    </p>
                                @endif
                            </div>

                                <div class="rs-post-meta-row">
                                    <div>
                                        <p>{{ $article->category->name }}</p>
                                    </div>

                                    <div class="rs-meta-item">
                                        <span>Democracy Asia, {{ optional($article->published_at)->format('F Y') }}</span>
                                    </div>

                                </div>

                                <h1 class="rs-blog-post-title">
                                    {{ $article->title }}
                                </h1>

                            </div>

                            <div class="article-body-content">

                                <div>
                                    <p class="article-excerpt">{{ $article->excerpt }}</p>
                                </div>

                                <div class="rs-meta-item" style="margin-bottom: 18px;">
                                    <i class="ri-time-line"></i>
                                    @php
$wordCount = str_word_count(strip_tags($article->content));
$readingTime = ceil($wordCount / 200);
                                    @endphp
                                    <span>{{ $readingTime }}-minute read</span>
                                </div>

                                <div class="rs-featured-img-container">
                                    <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                        alt="{{ $article->title }}">
                                </div>

                                <p style="font-weight: 800; margin-bottom: 15px;">{{ $article->featured_image_description }}</p>

                                <div class="article-content">
                                    {!! $cleanContent !!}
                                </div>
                            </div>

                            <!-- @if($canRead)
                                                                                                                                                <div class="article-body-content">
                                                                                                                                                    {!! $cleanContent !!}
                                                                                                                                                </div>
                                                                                                                                            @else
                                                                                                                                                <div class="article-body-content">
                                                                                                                                                    {!! $preview !!}
                                                                                                                                                </div>

                                                                                                                                                <div class="rs-paywall-preview">
                                                                                                                                                    <div class="article-body-content"
                                                                                                                                                        style="filter: blur(8px); user-select: none; pointer-events: none; height: 200px; overflow: hidden; opacity: 0.6;">
                                                                                                                                                        {!! $remaining !!}
                                                                                                                                                    </div>

                                                                                                                                                    <div class="rs-paywall-gradient"></div>

                                                                                                                                                  <div class="rs-subscribe-cta" style="
                                                                                                                                                        background: linear-gradient(135deg, #0f172a 0%, #1e293b 45%, #334155 100%);
                                                                                                                                                        padding: 40px 30px;
                                                                                                                                                        border-radius: 24px;
                                                                                                                                                        box-shadow: 0 20px 50px rgba(0,0,0,0.18);
                                                                                                                                                        border: 1px solid rgba(255,255,255,0.08);
                                                                                                                                                        position: relative;
                                                                                                                                                        overflow: hidden;
                                                                                                                                                    ">

                                                                                                                                                        <div style="
                                                                                                                                                            position: absolute;
                                                                                                                                                            top: -60px;
                                                                                                                                                            right: -60px;
                                                                                                                                                            width: 180px;
                                                                                                                                                            height: 180px;
                                                                                                                                                            background: rgba(255,255,255,0.05);
                                                                                                                                                            border-radius: 50%;
                                                                                                                                                        "></div>

                                                                                                                                                        <div style="
                                                                                                                                                            position: absolute;
                                                                                                                                                            bottom: -50px;
                                                                                                                                                            left: -50px;
                                                                                                                                                            width: 140px;
                                                                                                                                                            height: 140px;
                                                                                                                                                            background: rgba(59,130,246,0.12);
                                                                                                                                                            border-radius: 50%;
                                                                                                                                                        "></div>

                                                                                                                                                        <div style="position: relative; z-index: 2;">
                                                                                                                                                            <span style="
                                                                                                                                                                display: inline-block;
                                                                                                                                                                background: rgba(255,255,255,0.1);
                                                                                                                                                                color: #cbd5e1;
                                                                                                                                                                font-size: 12px;
                                                                                                                                                                font-weight: 600;
                                                                                                                                                                letter-spacing: 1px;
                                                                                                                                                                text-transform: uppercase;
                                                                                                                                                                padding: 8px 14px;
                                                                                                                                                                border-radius: 999px;
                                                                                                                                                                margin-bottom: 16px;
                                                                                                                                                            ">
                                                                                                                                                                Premium Access
                                                                                                                                                            </span>

                                                                                                                                                            <h3 style="
                                                                                                                                                                color: #ffffff;
                                                                                                                                                                font-size: 34px;
                                                                                                                                                                line-height: 1.2;
                                                                                                                                                                font-weight: 700;
                                                                                                                                                                margin-bottom: 14px;
                                                                                                                                                            ">
                                                                                                                                                                Unlock the Full Story
                                                                                                                                                            </h3>

                                                                                                                                                            <p style="
                                                                                                                                                                color: #cbd5e1;
                                                                                                                                                                font-size: 16px;
                                                                                                                                                                line-height: 1.8;
                                                                                                                                                                margin-bottom: 26px;
                                                                                                                                                                max-width: 650px;
                                                                                                                                                            ">
                                                                                                                                                                Get unlimited access to exclusive reports, sharp analysis, and the stories shaping Asia.
                                                                                                                                                                Enter your email to continue reading with Democracy Asia.
                                                                                                                                                            </p>

                                                                                                                                                            <form method="POST" action="{{ route('newsletter.subscribe') }}" style="margin: 0;">
                                                                                                                                                                @csrf

                                                                                                                                                                <div style="
                                                                                                                                                                    display: flex;
                                                                                                                                                                    flex-wrap: wrap;
                                                                                                                                                                    gap: 12px;
                                                                                                                                                                    align-items: center;
                                                                                                                                                                ">
                                                                                                                                                                    <input 
                                                                                                                                                                        type="email" 
                                                                                                                                                                        name="email" 
                                                                                                                                                                        placeholder="Enter your email address"
                                                                                                                                                                        value="{{ old('email') }}"
                                                                                                                                                                        required
                                                                                                                                                                        style="
                                                                                                                                                                            flex: 1 1 320px;
                                                                                                                                                                            height: 56px;
                                                                                                                                                                            border: 1px solid rgba(255,255,255,0.12);
                                                                                                                                                                            background: rgba(255,255,255,0.08);
                                                                                                                                                                            color: #ffffff;
                                                                                                                                                                            padding: 0 18px;
                                                                                                                                                                            border-radius: 14px;
                                                                                                                                                                            outline: none;
                                                                                                                                                                            font-size: 15px;
                                                                                                                                                                            box-shadow: none;
                                                                                                                                                                        "
                                                                                                                                                                    >

                                                                                                                                                                    <button 
                                                                                                                                                                        type="submit"
                                                                                                                                                                        style="
                                                                                                                                                                            height: 56px;
                                                                                                                                                                            padding: 0 28px;
                                                                                                                                                                            border: none;
                                                                                                                                                                            border-radius: 14px;
                                                                                                                                                                            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
                                                                                                                                                                            color: #ffffff;
                                                                                                                                                                            font-size: 15px;
                                                                                                                                                                            font-weight: 600;
                                                                                                                                                                            cursor: pointer;
                                                                                                                                                                            transition: all 0.3s ease;
                                                                                                                                                                            box-shadow: 0 10px 25px rgba(37,99,235,0.35);
                                                                                                                                                                            white-space: nowrap;
                                                                                                                                                                        "
                                                                                                                                                                    >
                                                                                                                                                                        Subscribe Free
                                                                                                                                                                    </button>
                                                                                                                                                                </div>
                                                                                                                                                            </form>

                                                                                                                                                            @if(session('newsletter_success'))
                                                                                                                                                                <div style="
                                                                                                                                                                    margin-top: 16px;
                                                                                                                                                                    padding: 14px 16px;
                                                                                                                                                                    border-radius: 12px;
                                                                                                                                                                    background: rgba(34,197,94,0.14);
                                                                                                                                                                    border: 1px solid rgba(34,197,94,0.28);
                                                                                                                                                                    color: #dcfce7;
                                                                                                                                                                    font-size: 14px;
                                                                                                                                                                    font-weight: 500;
                                                                                                                                                                ">
                                                                                                                                                                    {{ session('newsletter_success') }}
                                                                                                                                                                </div>
                                                                                                                                                            @endif

                                                                                                                                                            @if(session('error'))
                                                                                                                                                                <div style="
                                                                                                                                                                    margin-top: 16px;
                                                                                                                                                                    padding: 14px 16px;
                                                                                                                                                                    border-radius: 12px;
                                                                                                                                                                    background: rgba(239,68,68,0.14);
                                                                                                                                                                    border: 1px solid rgba(239,68,68,0.28);
                                                                                                                                                                    color: #fee2e2;
                                                                                                                                                                    font-size: 14px;
                                                                                                                                                                    font-weight: 500;
                                                                                                                                                                ">
                                                                                                                                                                    {{ session('error') }}
                                                                                                                                                                </div>
                                                                                                                                                            @endif

                                                                                                                                                            @error('email')
                                                                                                                                                                <div style="
                                                                                                                                                                    margin-top: 16px;
                                                                                                                                                                    padding: 14px 16px;
                                                                                                                                                                    border-radius: 12px;
                                                                                                                                                                    background: rgba(239,68,68,0.14);
                                                                                                                                                                    border: 1px solid rgba(239,68,68,0.28);
                                                                                                                                                                    color: #fee2e2;
                                                                                                                                                                    font-size: 14px;
                                                                                                                                                                    font-weight: 500;
                                                                                                                                                                ">
                                                                                                                                                                    {{ $message }}
                                                                                                                                                                </div>
                                                                                                                                                            @enderror
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            @endif -->

                            <!-- Tags -->


                            <!-- Author Box -->
                            <div class="rs-author-box">
                                <div class="rs-author-info">
                                    <h4 style="font-style: italic;">By <span>{{ $article->auther ?? 'Editorial Staff' }}</span>
                                    </h4>
                                    <p>
                                        {!! $article->auther_description ?: 'Our dedicated team of journalists and editors work tirelessly to bring you the most accurate and insightful news coverage. With a passion for storytelling and a commitment to journalistic integrity, our team strives to keep you informed about the latest developments shaping our world.' !!}
                                    </p>
                                </div>
                            </div>

                            <!-- Related News -->
                            @if($relatedArticles->count())
                                <div class="mt-60">
                                    <h4 class="font-serif mb-4">Related News</h4>

                                    <div class="row g-4">
                                        @foreach($relatedArticles as $related)
                                            <div class="col-xl-6 col-md-6 mb-4">
                                                <div class="custom-news-card"
                                                    style="border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden; background: #fff; height: 100%; display: flex; flex-direction: column; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);">

                                                    <div class="card-thumb"
                                                        style="aspect-ratio: 16/10; overflow: hidden; flex-shrink: 0;">
                                                        <a href="{{ route('news.show', $related->slug) }}" class="hover-zoom-img">
                                                            <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : asset('assets/images/default/news-placeholder.webp') }}"
                                                                alt="{{ $related->title }}"
                                                                style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                                                        </a>
                                                    </div>

                                                    <div class="card-content"
                                                        style="padding: 15px; display: flex; flex-direction: column; flex-grow: 1;">

                                                        <h3 class="card-title"
                                                            style="font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 14px; line-height: 1.3;">
                                                            <a href="{{ route('news.show', $related->slug) }}"
                                                                style="color: inherit; text-decoration: none;">
                                                                {{ \Illuminate\Support\Str::limit($related->title, 70) }}
                                                            </a>
                                                        </h3>

                                                        <div class="card-meta"
                                                            style="display: flex; align-items: center; flex-wrap: wrap; gap: 16px; font-size: 14px; color: #6b7280; margin-bottom: 16px;">
                                                            @if ($related->auther)
                                                                <span style="display: flex; align-items: center;">
                                                                    By <span
                                                                        style="color: #4b5563; margin-left: 4px;">{{ $related->auther }}</span>
                                                                </span>
                                                            @endif

                                                            <!-- <span style="display: flex; align-items: center; gap: 6px;">
                                                                                                                                                                                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                                                                                                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                                                                                                                                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                                                                                                                                                                                            </svg>
                                                                                                                                                                                                            {{ number_format($related->views) }} Views
                                                                                                                                                                                                        </span> -->

                                                            <span style="display: flex; align-items: center; gap: 6px;">
                                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                                </svg>
                                                                {{ optional($related->published_at)->format('F Y') }}
                                                            </span>
                                                        </div>

                                                        <p class="card-desc"
                                                            style="font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">
                                                            {{ $related->excerpt ?: strip_tags($related->content) }}
                                                        </p>

                                                        <div class="card-footer" style="margin-top: auto;">
                                                            <a href="{{ route('news.show', $related->slug) }}"
                                                                style="color: #2563eb; font-weight: 600; font-size: 15px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: color 0.2s;">
                                                                See more
                                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                                                </svg>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-4 col-lg-4">
                        @include('news.partials.news-sidebar')
                    </div>
                </div>
            </div>
        </section>

        <script>
            window.onscroll = function () {
                var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                var scrolled = (winScroll / height) * 100;
                document.getElementById("rsReadingProgress").style.width = scrolled + "%";
            };

            function copyArticleLink() {
                const url = "{{ url()->current() }}";
                navigator.clipboard.writeText(url).then(function () {
                    alert("Link copied to clipboard!");
                });
            }
        </script>

@endsection