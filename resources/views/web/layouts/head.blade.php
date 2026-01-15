 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Preload Hero Image -->
    <link rel="preload" as="image" href="{{ asset('assets/web/dashboard/dashboard.jpg') }}">
    @include('web.layouts.meta',['meta' => $meta ?? []])
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="{{ asset('css/final.css') }}">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <!-- Global Schema (Organization) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $settings['system_name'] ?? 'PT. Perkalin Indah' }}",
      "url": "{{ url('/') }}",
      "logo": "{{ asset($settings['system_logo'] ?? 'assets/web/logo.png') }}",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ $settings['contact_phone'] ?? '' }}",
        "contactType": "customer service"
      },
      "sameAs": [
        "{{ $settings['social_facebook'] ?? '' }}",
        "{{ $settings['social_instagram'] ?? '' }}",
        "{{ $settings['social_twitter'] ?? '' }}"
      ]
    }
    </script>
    @stack('schema')
 <style>
     .hero-bg {
         background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
         url('{{ asset("assets/web/dashboard/dashboard.jpg") }}');
         background-size: cover;
         background-position: center;
     }

     .about-bg {
         background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
         url('{{ asset("assets/web/dashboard/background-1.jpg") }}');
         background-size: cover;
         background-position: center;
     }

     @keyframes scroll-left {
         0% {
             transform: translateX(0);
         }

         100% {
             transform: translateX(-50%);
         }
     }

     @keyframes scroll-right {
         0% {
             transform: translateX(-50%);
         }

         100% {
             transform: translateX(0);
         }
     }

     .track-left {
         animation: scroll-left 22s linear infinite;
     }

     .track-right {
         animation: scroll-right 22s linear infinite;
     }

     /* ====== MOBILE FIX FOR TRUSTED LOGOS ====== */
     @media (max-width: 640px) {

         /* Ukuran logo diperkecil */
         #trusted-by img {
             height: 40px !important;
             filter: none !important;
             /* Hilangkan grayscale */
             opacity: 1 !important;
             /* Pastikan terang */
         }

         /* Jarak antar logo di mobile */
         .track-left,
         .track-right {
             gap: 2.5rem !important;
             /* default 16 → jadi 10 */
         }

         /* Scroll lebih cepat di mobile (22s → 12s) */
         @keyframes scroll-left-mobile {
             0% {
                 transform: translateX(0);
             }

             100% {
                 transform: translateX(-50%);
             }
         }

         @keyframes scroll-right-mobile {
             0% {
                 transform: translateX(-50%);
             }

             100% {
                 transform: translateX(0);
             }
         }

         .track-left {
             animation: scroll-left-mobile 6s linear infinite !important;
         }

         .track-right {
             animation: scroll-right-mobile 6s linear infinite !important;
         }
     }
 </style>