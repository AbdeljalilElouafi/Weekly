@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trash (Soft Deleted Posts)</h1>
    
    {{-- Check for success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Posts table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->status }}</td>
                    <td>{{ $post->category->nom }}</td>
                    <td>
                        <a href="{{ route('posts.restore', $post->id) }}" class="btn btn-success btn-sm">Restore</a>
                        <form action="{{ route('posts.forceDelete', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination links --}}
    {{ $posts->links() }}
</div>
@endsection
