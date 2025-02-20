@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des catégories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Ajouter une catégorie</a>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->nom }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('categories.trashed') }}" class="btn btn-primary">Trash bin</a>
    </div>
@endsection
