<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('public.layouts.head')
    </head>
    <body class="border-top-wide d-flex flex-column">
        <div class="page">
        {{--    @include('public.layouts.header')--}}
            <main>
                @yield('content'),
                @yield('contentdetail')
            </main>
                @include('public.layouts.footer')
                @include('public.layouts.scripts')
            <x-alert />
        </div>
    </body>
</html>
