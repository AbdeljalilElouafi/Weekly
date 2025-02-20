@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer une nouvelle catégorie</h1>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nom">Nom de la catégorie</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" required>
            </div>

            <button type="submit" class="btn btn-primary">Créer la catégorie</button>
        </form>
    </div>
@endsection