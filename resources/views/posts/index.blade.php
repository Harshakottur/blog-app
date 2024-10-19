@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-between align-center mb-3">
        <h1>All Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary fade-in">Create New Post</a>
    </div>

    @if (session('status'))
        <div class="alert card mb-3 fade-in" style="background-color: var(--secondary-color); color: white;">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('posts.index') }}" method="GET" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Search posts..." class="form-control me-2" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>


</form>

    @if($posts->count())
        <div class="posts-grid fade-in">
            @foreach($posts as $post)
                <div class="post-card card">
                    @if($post->image)
                        <div class="post-image">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image">
                        </div>
                    @else
                        <div class="post-image-placeholder">
                            <span>No Image</span>
                        </div>
                    @endif
                    
                    <div class="post-content">
                        <h2 class="post-title">
                            <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="post-description">{{ Str::limit($post->description, 100) }}</p>
                    </div>

                    <div class="post-footer">
                        <div class="post-meta">
                            <div class="post-author">
                                <small>By {{ $post->user->name }}</small>
                            </div>
                            <div class="post-date">
                                <small>{{ $post->created_at->format('d M, Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="pagination">
            {{ $posts->appends(['search' => request()->input('search')])->links() }}
        </div>

    @else
        <div class="card text-center fade-in">
            <p>No posts available.</p>
        </div>
    @endif
</div>
@endsection