<div class="ad-box {{ $class ?? '' }}" id="{{ ($class ?? '') == 'home-top-ad' ? 'homeTopAd' : '' }}" style="
        {{ $style ?? '' }};
        width: {{ $width ?? '100%' }};
        height: {{ $height ?? '250px' }};
    ">

    @if(isset($image))

        <div class="ad-image-wrapper">

            <!-- Close Button -->
            <button class="ad-close-btn" onclick="this.closest('.ad-box').style.display = 'none';" aria-label="Close Ad">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>


            <!-- Advertisement Image -->
            <img src="{{ $image }}" alt="Advertisement" class="ad-image">

            <!-- Ad Label -->
            <span class="ad-label">Ad</span>

        </div>

    @else
        <span class="ad-text">ADVERTISEMENT</span>
    @endif

</div>

<style>
    .ad-box {
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        overflow: hidden;
        border-radius: 10px;
        position: relative;
        width: 100%;
        height: 250px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Advertisement Text */
    .ad-text {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        letter-spacing: 1px;
    }

    /* Image Wrapper */
    .ad-image-wrapper {
        width: 100%;
        height: 100%;
        position: relative;
        background: #fff;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Advertisement Image */
    .ad-image {
        max-width: 100%;
        max-height: 100%;
        height: 100%;
        width: 100%;
        object-fit: contain;
        display: block;
        transition: transform 0.3s ease;
    }

    /* Hover Effect */
    .ad-box:hover .ad-image {
        transform: scale(1.01);
    }

    /* Close Button ON IMAGE */
    .ad-close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 26px;
        height: 26px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.7); /* Premium slate-900 with opacity */
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        color: rgba(255, 255, 255, 0.9);
        cursor: pointer;
        z-index: 10;
        padding: 0;

        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ad-close-btn svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hover & Active Effects */
    .ad-close-btn:hover {
        background: rgba(15, 23, 42, 0.95);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.45);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        transform: scale(1.08);
    }

    .ad-close-btn:hover svg {
        transform: rotate(90deg);
    }

    .ad-close-btn:active {
        transform: scale(0.95);
    }

    /* Ad Label */
    .ad-label {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 20px;
        z-index: 2;
    }

    /* 🔥 DARK MODE */
    .ad-box.dark {
        background-color: #111;
        border: 1px solid #333;
    }

    .ad-box.dark .ad-text {
        color: #aaa;
    }
</style>

<script>
    // Disable browser automatic scroll restore
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }

    function closeTopAd() {
        const ad = document.getElementById('homeTopAd');

        if (ad) {
            ad.style.display = 'none';
        }
    }

    // Smoothly open page directly from advertisement
    document.addEventListener('DOMContentLoaded', function () {

        const ad = document.getElementById('homeTopAd');

        if (ad) {
            window.scrollTo(0, ad.offsetTop);
        }

    });
</script>