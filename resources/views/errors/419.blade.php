@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __(($exception->getMessage() && (config('app.env') !== 'production')) ? $exception->getMessage() : "Page Expired"))
