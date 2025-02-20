@extends('layouts.app')
@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Posts</h1>
        <div>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create Post
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Title</th>
                        <th class="px-4">Description</th>
                        <th class="px-4">Category</th>
                        <th class="px-4">Status</th>
                        <th class="px-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td class="px-4">{{ $post->title }}</td>
                            <td class="px-4">{{ Str::limit($post->description, 100) }}</td>
                            <td class="px-4">
                                <span class="badge bg-info text-dark">{{ $post->category->nom }}</span>
                            </td>
                            <td class="px-4">
                                @switch($post->status)
                                    @case('active')
                                        <span class="badge bg-success">Active</span>
                                        @break
                                    @case('draft')
                                        <span class="badge bg-warning text-dark">Draft</span>
                                        @break
                                    @case('archived')
                                        <span class="badge bg-secondary">Archived</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-4 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('posts.edit', $post->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ route('posts.trashed') }}" class="btn btn-outline-secondary">
            <i class="bi bi-trash"></i> Trash Bin
        </a>
        <div>
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection