
@extends('layouts.app')

@section('titre', 'Modifier une catégorie')

@section('contenu')

<div class="conteneur">

    <h1>Modifier une catégorie</h1>

   <form action="{{ route('contenus.update', ['contenu' => request()->route('contenu')]) }}"
      method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="nom">Nom de la catégorie</label>

            <input
                type="text"
                name="nom"
                id="nom"
                value="{{ old('nom', $categorie->nom) }}"
                required
            >
        </div>

        <div>
            <label for="slug">Slug</label>

            <input
                type="text"
                name="slug"
                id="slug"
                value="{{ old('slug', $categorie->slug) }}"
                required
            >
        </div>

        <button type="submit">
            Enregistrer les modifications
        </button>

        <a href="{{ route('categories.index') }}">
            Annuler
        </a>

    </form>

</div>

@endsection
