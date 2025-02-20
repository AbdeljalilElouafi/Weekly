@extends('layouts.app')

@section('content')
    <h1>Trash Bin (Soft Deleted Categories)</h1>

    @if($categories->isEmpty())
        <p>No categories in the trash bin.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->nom }}</td>
                        <td>
                            <!-- Restore Button -->
                            <form action="{{ route('categories.restore', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Restore</button>
                            </form>

                            <!-- Permanently delete button -->
                            <form action="{{ route('categories.forceDelete', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to permanently delete this category?')">Delete Permanently</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('categories.index') }}">Back to Categories</a>
@endsection
