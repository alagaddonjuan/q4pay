<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Q4I Limited | Secure Escrow & Vendor Payouts')</title>
    <meta name="title" content="@yield('title', 'Q4I Limited | Secure Escrow & Vendor Payouts')">
    <meta name="description" content="@yield('meta_description', 'Nigeria\'s premier secure escrow and vendor payout platform. Buy and sell with confidence across WhatsApp, Instagram, and the web.')">
    <meta name="keywords" content="escrow, payments, vendor dashboard, Q4I, fintech, secure transactions, nigeria">
    <meta name="author" content="Q4I Limited">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Q4I Limited | Secure Escrow & Vendor Payouts')">
    <meta property="og:description" content="@yield('meta_description', 'Secure your transactions with Q4I Escrow. Funds are locked until delivery is verified.')">
    <meta property="og:image" content="@yield('meta_image', asset('assets/images/q4i-social-share.jpg'))">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Q4I Limited | Secure Escrow & Vendor Payouts')">
    <meta property="twitter:description" content="@yield('meta_description', 'Secure your transactions with Q4I Escrow. Funds are locked until delivery is verified.')">
    <meta property="twitter:image" content="@yield('meta_image', asset('assets/images/q4i-social-share.jpg'))">

    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">

    @vite(['resources/css/app.css'])
    
    @stack('styles')
</head>

<body class="vertical bg-[#F8FAFC] dark:bg-[#0F172A] transition-colors duration-300">
    {{-- 
    <div class="loader flex items-center justify-center min-w-screen min-h-screen fixed !z-50 inset-0 bg-n0 ">
        <svg viewBox="25 25 50 50">
            <circle r="20" cy="50" cx="50"></circle>
        </svg>
    </div> 
    --}}