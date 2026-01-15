<!DOCTYPE html>
<html lang="en">

<head>
    @include('web.layouts.head')
</head>

<body>
    @include('web.layouts.header', ['menus' => $menus ?? []])
    <main>
        @yield('content')
    </main>
    @include('web.layouts.footer')
    @include('web.layouts.scripts')
</body>