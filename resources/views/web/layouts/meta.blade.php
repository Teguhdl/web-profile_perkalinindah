<title>{{ $meta['title'] ?? 'PT. Perkalin Indah' }}</title>
<meta name="description" content="{{ $meta['description'] ?? '' }}">
<meta name="keywords" content="{{ $meta['keywords'] ?? '' }}">
<meta name="robots" content="{{ $meta['robots'] ?? 'index, follow' }}">
<meta name="author" content="PT. Perkalin Indah">
<meta name="theme-color" content="#dc2626">
<link rel="canonical" href="{{ $meta['canonical'] ?? url()->current() }}">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $meta['og_type'] ?? 'website' }}">
<meta property="og:site_name" content="PT. Perkalin Indah">
<meta property="og:title" content="{{ $meta['title'] ?? 'PT. Perkalin Indah' }}">
<meta property="og:description" content="{{ $meta['description'] ?? '' }}">
<meta property="og:url" content="{{ $meta['canonical'] ?? url()->current() }}">
<meta property="og:image" content="{{ $meta['og_image'] ?? (!empty($settings['system_logo']) ? asset($settings['system_logo']) : asset('assets/web/logo/logo.png')) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="id_ID">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $meta['title'] ?? 'PT. Perkalin Indah' }}">
<meta name="twitter:description" content="{{ $meta['description'] ?? '' }}">
<meta name="twitter:image" content="{{ $meta['og_image'] ?? (!empty($settings['system_logo']) ? asset($settings['system_logo']) : asset('assets/web/logo/logo.png')) }}">

{{-- Geo Tagging (untuk lokal SEO) --}}
<meta name="geo.region" content="ID-JB">
<meta name="geo.placename" content="Subang, Jawa Barat">
<meta name="geo.position" content="-6.5712;107.7572">
<meta name="ICBM" content="-6.5712, 107.7572">
