<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Laravel101') - Tasks Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- @vite('resources/css/app.css') <!-- Use this for tailwind css --> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}} <!-- Use this for bootstrap css -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @if(session('flash-message'))
        <div style="display: none" class="flash-message"
            data-type="{{ session('flash-type') }}"
            data-dismiss="{{ session('flash-dismiss') }}"
            data-position="{{ session('flash-position') }}"
            data-closebutton="{{ session('flash-closebutton') }}">
            {!! session('flash-message') !!}
        </div>
    @endif

</head>
<body>
