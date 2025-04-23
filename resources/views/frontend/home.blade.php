@extends('frontend.layouts.app')

@section('title', 'My Tasks')

@section('content')
   <h1>My Tasks</h1>
    <ul>
        @foreach ($tasks as $task) 
            <li> {{ $task->title }} </li>
        @endforeach
    <ul>
@endsection