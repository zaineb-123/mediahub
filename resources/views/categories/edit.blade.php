
@extends('layouts.app')

@section('titre', 'Modifier une catégorie')

@section('contenu')

<div class="conteneur">
    <h1>Modifier une catégorie</h1>

    <form action="{{ route('categories.update', ['categorie' => $categorie->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nom --}}
        <div class="form-group">
            <label for="nom">Nom de la catégorie</label>

            <input
                type="text"
                id="nom"
                name="nom"
                value="{{ old('nom', $categorie->nom) }}"
                class="@error('nom') is-invalid @enderror"
                placeholder="Exemple : Technologie"
            >

            @error('nom')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        {{-- Slug --}}
        <div class="form-group">
            <label for="slug">Slug</label>

            <input
                type="text"
                id="slug"
                name="slug"
                value="{{ old('slug', $categorie->slug) }}"
                class="@error('slug') is-invalid @enderror"
                placeholder="Exemple : technologie"
            >

            @error('slug')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Enregistrer les modifications</button>

        <a href="{{ route('categories.index') }}">Annuler</a>
    </form>
</div>

@endsection
