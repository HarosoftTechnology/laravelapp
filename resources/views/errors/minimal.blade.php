@include('frontend.layouts.header')
@include('frontend.layouts.menu')
@php
    $number = trim($__env->yieldContent('code'));
    $first = $number[0]; // First digit
    $last = $number[strlen($number) - 1]; // Last digit
    $middle = substr($number, 1, strlen($number) - 2); // Middle digit(s)
@endphp
<style type="text/css">
    .container-xxl {
        display: flex; /* Enable Flexbox */
        justify-content: center; /* Horizontally center */
        align-items: center; /* Vertically center */
        height: 100vh; /* Full viewport height */
    }
    .wrap {
        text-align: center;
        font-family: 'Love Ya Like A Sister', cursive;
    }
    .code {
        font-size: 10em;
    }
    .code span {
        color: #93BA09;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y page-content">
    <div class="wrap">
        <div style="color:#272727; font-size:40px;">@yield('title')</div>
        <div class="code">
            <span>{{ $first }}</span>{{ $middle }}<span>{{ $last }}</span>
        </div>
        <div>@yield('message')</div>
    </div>
</div>