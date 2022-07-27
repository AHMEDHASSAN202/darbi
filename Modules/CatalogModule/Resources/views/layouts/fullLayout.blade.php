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
<html lang="{{__get_lang()}}">
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

<main role="main" class="main-app" class="bg-grey-light">
    {{-- <div class="container"> --}}
    @yield('content')
    {{-- </div> --}}
</main>


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
