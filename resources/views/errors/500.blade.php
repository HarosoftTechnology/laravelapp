@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __(($exception->getMessage() && (config('app.env') !== 'production')) ? $exception->getMessage() : "Server Error"))
