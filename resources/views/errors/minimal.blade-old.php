<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <style type="text/css">
            .wrap{
                margin:0 auto;
                width:100%;
                text-align:center;
                padding: 5% 0;
                font-family: 'Love Ya Like A Sister', cursive;
            }
            .code{
                font-size:10em;
            }
            .code span {
                color:#93BA09
            }
        </style>
    </head>
    @php
        $number = trim($__env->yieldContent('code'));
        $first = $number[0]; // First digit
        $last = $number[strlen($number) - 1]; // Last digit
        $middle = substr($number, 1, strlen($number) - 2); // Middle digit(s)
    @endphp

    <body class="antialiased">
        <div class="container-xxl flex-grow-1 container-p-y page-content">
            <div class="wrap">
                <div style="color:#272727; font-size:40px; ">@yield('title')<?php // echo nl2br(esc($message)) ?></div>
                <div class="code">
                    <span>{{ $first }}</span>{{ $middle }}<span>{{ $last }}</span>
                </div>
                
                <div>@yield('message')</div>
            </div>
        </div>
    </body>
</html>
