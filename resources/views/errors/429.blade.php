@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __(($exception->getMessage() && (config('app.env') !== 'production')) ? $exception->getMessage() : "Too Many Requests"))
