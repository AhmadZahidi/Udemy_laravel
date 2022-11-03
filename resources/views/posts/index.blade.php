@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    {{-- @each('posts.partials.post', $posts, 'post') --}}
    @forelse ($posts as $post)
        <p>
            @include('posts.partials.post', [])
        </p>
    @empty
        No posts found!
    @endforelse

@endsection
