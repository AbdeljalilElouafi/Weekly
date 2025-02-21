@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        <a href="{{ url('/') }}" class="btn btn-primary mb-3 btn-lg gap-3">Back to Home</a>

            <!-- Post Card -->
            <div class="card shadow-sm mb-4">
                
                @if($post->image)
                    <img src="{{ Storage::url($post->image) }}" 
                         class="card-img-top" 
                         alt="{{ $post->title }}"
                         style="max-height: 400px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary">{{ $post->category->nom }}</span>
                        <small class="text-muted">Posted {{ $post->created_at->diffForHumans() }}</small>
                    </div>

                    <h1 class="card-title mb-3">{{ $post->title }}</h1>
                    
                    @if($post->price)
                        <h4 class="text-primary mb-3">${{ number_format($post->price, 2) }}</h4>
                    @endif

                    <p class="card-text fs-5">{{ $post->description }}</p>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div class="d-flex align-items-center gap-3">
                            @auth
                                @if($post->isLikedBy(auth()->user()))
                                    <form action="{{ route('posts.unlike', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-heart-fill"></i> Unlike
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('posts.like', $post) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-heart"></i> Like
                                        </button>
                                    </form>
                                @endif
                            @endauth
                            <span class="text-muted">
                                {{ $post->likes()->count() }} {{ Str::plural('like', $post->likes()->count()) }}
                            </span>
                        </div>
                        <div>
                            <i class="bi bi-chat-dots"></i>
                            {{ $post->comments()->count() }} {{ Str::plural('comment', $post->comments()->count()) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">Comments</h3>

                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" 
                                          name="content" 
                                          rows="3" 
                                          placeholder="Leave a comment..."
                                          required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            Please <a href="{{ route('login') }}">login</a> to leave a comment.
                        </div>
                    @endauth

                    <div class="comments-list">
                        @forelse($post->comments()->latest()->get() as $comment)
                            <div class="comment border-bottom py-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                    <small class="text-muted">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="text-muted text-center">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (optional) -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">About the Author</h5>
                    <p class="card-text">{{ $post->user->name }}</p>
                    <p class="card-text">
                        <small class="text-muted">
                            Member since {{ $post->user->created_at->format('M Y') }}
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection