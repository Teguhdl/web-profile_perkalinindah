 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta name="google-site-verification" content="UwRsNHd2AjSapOAnKySlIC6GzVWWcS2jpfEwyYH4xyc" />
 
    @if(str_contains(request()->getHost(), 'teguhdl.com') || config('app.env') !== 'production')
        <!-- Block indexing on staging / development server -->
        <meta name="robots" content="noindex, nofollow" />
    @endif

    <!-- Favicon / Logo Browser -->
    <link rel="icon" type="image/png" href="{{ asset($settings['system_logo'] ?? 'assets/web/logo/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($settings['system_logo'] ?? 'assets/web/logo/logo.png') }}">

    @if(!empty($settings['google_analytics_id']))
    <!-- Google Tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $settings['google_analytics_id'] }}');
    </script>
    @endif
    <!-- Preload Hero Image -->
    <link rel="preload" as="image" href="{{ asset('assets/web/dashboard/dashboard.webp') }}">
    @include('web.layouts.meta',['meta' => $meta ?? []])
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="{{ asset('css/final.css') }}">
    <!-- CKE Design System Tokens -->
    <link rel="stylesheet" href="{{ asset('css/tokens/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tokens/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tokens/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tokens/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tokens/base.css') }}">
    <!-- CKE UI Kit & Components -->
    <link rel="stylesheet" href="{{ asset('css/cke-kit.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/cke-components.css') }}?v={{ time() }}">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Schema: Organization --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $settings['system_name'] ?? 'PT. Perkalin Indah' }}",
      "alternateName": "Perkalin Indah",
      "url": "{{ url('/') }}",
      "logo": "{{ asset($settings['system_logo'] ?? 'assets/web/logo/logo.png') }}",
      "foundingDate": "1973",
      "description": "Manufaktur terpercaya produk karet, polyurethane, logam, dan plastik untuk kebutuhan industri, teknik, dan konstruksi di Indonesia.",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ $contact_phone ?? ($settings['contact_phone'] ?? '(0260) 4641643') }}",
        "email": "{{ $contact_email ?? ($settings['contact_email'] ?? 'marketing@perkaliindah.com') }}",
        "contactType": "customer service",
        "areaServed": "ID",
        "availableLanguage": ["Indonesian","English"]
      },
      "sameAs": [
        @if(!empty($social_facebook)) "{{ $social_facebook }}", @endif
        @if(!empty($social_instagram)) "{{ $social_instagram }}", @endif
        @if(!empty($social_twitter)) "{{ $social_twitter }}" @else "" @endif
      ]
    }
    </script>

    {{-- Schema: LocalBusiness — penting untuk Google Maps & Local Pack --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "@id": "{{ url('/') }}#localbusiness",
      "name": "PT. Perkalin Indah",
      "image": "{{ asset('assets/web/logo/logo.png') }}",
      "url": "{{ url('/') }}",
      "telephone": "{{ $contact_phone ?? ($settings['contact_phone'] ?? '(0260) 4641643') }}",
      "email": "{{ $contact_email ?? ($settings['contact_email_1'] ?? 'marketing@perkaliindah.com') }}",
      "priceRange": "$$",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Cibeuying, Wantilan",
        "addressLocality": "Subang",
        "addressRegion": "Jawa Barat",
        "postalCode": "41272",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.5712,
        "longitude": 107.7572
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
          "opens": "08:00",
          "closes": "18:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Saturday",
          "opens": "09:00",
          "closes": "14:00"
        }
      ]
    }
    </script>

    {{-- Schema: WebSite (untuk sitelinks searchbox di Google) --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "url": "{{ url('/') }}",
      "name": "PT. Perkalin Indah",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/produk') }}?search={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

    @stack('schema')
 <style>
     .hero-bg {
         background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
         url('{{ asset("assets/web/dashboard/dashboard.webp") }}');
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