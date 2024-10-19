@extends('layouts.app')

@section('content')
<div class="container">
    <div class="post-detail-card card fade-in">
        <div class="post-detail-header">
            <h1>{{ $post->title }}</h1>
            <div class="post-meta">
                <span class="author">By {{ $post->user->name }}</span>
                <span class="date">{{ $post->created_at->format('d M, Y H:i') }}</span>
            </div>
        </div>

        @if($post->image)
            <div class="post-detail-image">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image">
            </div>
        @endif

        <div class="post-detail-content">
            <p>{{ $post->description }}</p>
        </div>

        <div class="post-detail-actions">
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to Posts</a>
            @can('update', $post)
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
            @endcan

            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            @endcan
        </div>
    </div>
</div>
@endsection