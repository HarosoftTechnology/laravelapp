@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __(($exception->getMessage() && (config('app.env') !== 'production')) ? $exception->getMessage() : "Unauthorized"))
