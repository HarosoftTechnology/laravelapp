@extends('errors::minimal')

@section('title', "Page Not Found")
@section('code', '404')
@section('message', __(($exception->getMessage() && (config('app.env') !== 'production')) ? $exception->getMessage() : "Sorry, we couldn't find that page."))
