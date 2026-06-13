<!DOCTYPE html>
<html lang="en">

<head>
    @include('web.layouts.head')
</head>

<body class="cke-app">
    @include('web.layouts.header', ['menus' => $menus ?? []])
    <main>
        @yield('content')
    </main>
    @include('web.layouts.footer')
    @include('web.layouts.scripts')
    @stack('scripts')
</body>