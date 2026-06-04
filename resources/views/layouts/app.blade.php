<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="template-version" content="1.0.3">
    <title>@yield('title', 'Democracy Asia')</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'Democracy Asia')">
    <meta property="og:description" content="@yield('og_description', 'Latest news and insights from Democracy Asia')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="Democracy Asia">
    <meta property="og:image" content="@yield('og_image')">
    <meta property="og:image:secure_url" content="@yield('og_image')">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    
    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Democracy Asia')">
    <meta name="twitter:description" content="@yield('og_description', 'Latest news and insights from Democracy Asia')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/images/default/news-placeholder.webp'))">

    <meta name="google-site-verification" content="aqslu04Thax6gJsUfOc4dEY7TEKK53OElmYvBbzKmbA" />

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon-final.jpeg') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .rs-post-overlay-title {
            text-transform: none !important;
        }
        .rs-post-medium-title {
            text-transform: none !important;
        }
        a {
            text-transform: none !important;
        }
        :root {
            --rs-border-primary: #a09494;
        }
        .hide-on-mobile {
            display: block !important;
        }

        .hide-on-desktop {
            display: none !important;
        }
        .gap-on-mobile {
            gap:0;
        }
        .rs-post-overlay-four .rs-post-overlay-bg-thumb::after {
            background: linear-gradient(
                180deg,
                rgba(24, 51, 108, 0) 40%,
                rgba(24, 51, 108, 0.6) 100%
            );
        }
        .rs-post-overlay-one .rs-post-overlay-bg-thumb::after {
            background: linear-gradient(
                180deg,
                rgba(24, 51, 108, 0) 40%,
                rgba(24, 51, 108, 0.6) 100%
            );
        }
        .title-view-all{
            display: flex; 
            align-items: center; 
            justify-content: space-between;
        }
        @media only screen and (max-width: 768px) {
            .hide-on-mobile {
                display: none !important;
            }

            .hide-on-desktop {
                display: block !important;
            }
            .gap-on-mobile {
                gap: 15px;
            }
        }
    </style>

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5XWCPB98');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body class="rs-smoother-yes">

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5XWCPB98" height="0" width="0"
        style="display:none;visibility:hidden">
    </iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

@include('components.advertisement-box', [
    'width' => '100%',
    'height' => '200px',
    'image' => asset('assets/images/ad/advertisement.webp'),
    'class' => 'home-top-ad'
])

    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <div class="backtotop-wrap cursor-pointer">
        <i class="ri-arrow-up-s-line"></i>
    </div>

    <script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/lenis.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/rs-anim-int.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/rs-scroll-trigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/rs-splitText.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dark-light.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Newsletter Modal -->
    @include('components.subscribe-modal')

    <script>
        // Define the function globally
        function openNewsletterModal(mode = 'subscribe') {
                const modal = document.getElementById('daNewsletterModal');

                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';

                    modal.setAttribute('data-mode', mode);

                    document.getElementById('modalMode').value = mode;

                    updateModalContent(mode);
                }
            }

        function updateModalContent(mode) {
            const title = document.querySelector('.da-newsletter-right h3');
            const button = document.querySelector('.da-newsletter-btn');

            if (!title || !button) return;

            if (mode === 'login') {
                title.innerText = 'Login to Continue';
                button.innerText = 'Login';
            } else {
                title.innerText = 'Unlock Your Daily Briefing';
                button.innerText = 'Subscribe';
            }
        }

        // document.addEventListener('DOMContentLoaded', function () {
        //     const modal = document.getElementById('daNewsletterModal');
        //     const closeBtn = document.getElementById('daNewsletterClose');
        //     const overlay = modal ? modal.querySelector('.da-newsletter-overlay') : null;

        //     if (!modal) return;

        //     // 1. Check if we should auto-show (Timer)
        //     const now = Date.now();
        //     const closedUntil = localStorage.getItem('da_newsletter_closed_until');
        //     const isSuccess = modal.classList.contains('active'); // Checks if Laravel 'active' class is present from session

        //     if (!isSuccess && (!closedUntil || now > parseInt(closedUntil))) {
        //         setTimeout(() => {
        //             openNewsletterModal();
        //         }, 4000);
        //     }

        //     // 2. Close Logic
        //     function closeModal() {
        //         modal.classList.remove('active');
        //         document.body.style.overflow = '';

        //         // Set lockout for 24 hours only if NOT a success message
        //         // We don't want to nag them again tomorrow if they just subscribed
        //         const nextShowTime = Date.now() + (24 * 60 * 60 * 1000);
        //         localStorage.setItem('da_newsletter_closed_until', nextShowTime);
        //     }

        //     closeBtn?.addEventListener('click', closeModal);
        //     overlay?.addEventListener('click', closeModal);
        // });
    </script>
</body>

</html>