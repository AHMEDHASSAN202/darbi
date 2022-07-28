<?php
$u = auth('web')->user();
$currencies = [];
$lang = app()->getLocale();
$isEN = $lang === 'en';
$withbg = $withbg ?? false;
$bg_n = rand(1, 3);
$bg = asset("front/header/{$bg_n}.jpg")
?>
<!DOCTYPE html>
<html lang="{{$lang}}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
    <meta content="Bitwize" name="author">

    <title>{{$title ?? 'نموذج الحجوزات - NGO'}}</title>

    <link rel="icon" href="{{ asset('front/img/favicon.png?v=5') }}">
    {{-- @livewireStyles --}}
    <link rel="stylesheet" href="{{ asset('front/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    @stack('styles')

</head>
<body>

<header class="site-header" id="header" role="banner" style="position: absolute;width: 100%">
    @if($withbg)
        <div class="header-with-bg" data-bg="{{$bg}}">
            @endif
            <div class="container">

                <nav class="navbar navbar-light  navbar-expand-md px-0 py-3">
                    <div class="my-auto">
                        <a class="navbar-brand" href="/">
                            @if($isEN)
                                @include('commonmodule::components.logo', ['h' => 50])
                            @else
                                @include('commonmodule::components.logo-ar', ['h' => 50])
                            @endif
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse w-100 flex-md-column" id="navbarCollapse">
                        <div class="text-right w-100">
                            {{--                            <a href="/contact" class="color-white bold mx-4">{{t('app.contact-us')}}</a>--}}
                            {{--                            <a href="/about" class="color-white bold mx-4">{{t('app.about-us')}}</a>--}}
                            @if($isEN)
                                <a href="/lang/ar" class="nav-lang arabic color-white bold mx-2">العربية</a>
                            @else
                                <a href="/lang/en" class="nav-lang english color-white bold mx-2">English</a>
                            @endif
                        </div>
                    </div>
                </nav>

            </div><!--/.container-fluid -->

            @if($withbg) </div> @endif

</header>

<main role="main" class="main-app" class="bg-grey-light">
    {{-- <div class="container"> --}}
    @yield('content')
    {{-- </div> --}}
</main>

<footer class="bg-yellow">

    <div class="container _pt-12 _pb-10 _px-20 color-grren">
        <div class="row align-items-center">

            <div class="col-md-12 my-md-0">
                <ul class="text-left color-green fs-32 d-flex justify-content-center d-md-block">
                    <li class="d-inline-block px-2">
                        <a href="#" class="color-white borderGreen">
                            <i class="fa-brands fa-twitter fa-sm"></i>
                        </a>
                    </li>
                    <li class="d-inline-block px-2">
                        <a href="#" class="color-white borderGreen">
                            <i class="fa-brands fa-facebook fa-sm"></i>
                        </a>
                    </li>
                    <li class="d-inline-block px-2">
                        <a href="#" class="color-white borderGreen">
                            <i class="fa-brands fa-instagram fa-sm"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</footer>

@stack('modals')

{{-- @livewireScripts --}}

<script src="{{ asset('front/app.js') }}"></script>
@stack('scripts')

@if(!empty( session('msg')))
    <script>
        Notify.go("success", {title: "Success", msg: "{{session('msg')}}"})
    </script>
@endif
@if(!empty( session('errmsg')))
    <script>
        Notify.go("error", {title: "Error Occured", msg: "{{session('errmsg')}}"})
    </script>
@endif

{{-- @analytics --}}
</body>
</html>
