@extends('layouts.app')

@section('contenu')

<div class="container">

    <h1>Ajouter une catégorie</h1>

    <form action="{{ route('categories.store') }}" method="POST">

        @csrf
        @if ($errors->any())
    <div class="alerte alerte-erreur">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="mb-3">
            <label for="nom" class="form-label">
                Nom de la catégorie
            </label>

            <input
                type="text"
                name="nom"
                id="nom"
                class="form-control"
                value="{{ old('nom') }}"
                placeholder="Exemple : Technologie"
                required
            >
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">
                Slug
            </label>

            <input
                type="text"
                name="slug"
                id="slug"
                class="form-control"
                value="{{ old('slug') }}"
                placeholder="Exemple : technologie"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Enregistrer
        </button>

        <a href="{{ route('categories.index') }}"
           class="btn btn-secondary">
            Annuler
        </a>

    </form>

</div>

@endsection