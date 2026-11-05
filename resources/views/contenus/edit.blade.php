@extends('layouts.app')

@section('titre', 'Modifier une publication')

@section('contenu')

<div class="conteneur">

    <h1>Modifier une publication</h1>

   <form action="{{ route('contenus.update', ['contenu' => $publication->id]) }}"
      method="POST">

        @csrf
        @method('PUT')

        <div>
            <label for="titre">Titre</label>

            <input
                type="text"
                name="titre"
                id="titre"
                value="{{ old('titre', $publication->titre) }}"
                required
            >
        </div>

        <div>
            <label for="contenu">Contenu</label>

            <textarea name="contenu"
                      id="contenu"
                      required>{{ old('contenu', $publication->contenu) }}</textarea>
        </div>

        <div>
            <label for="categorie_id">Catégorie</label>

            <select name="categorie_id" id="categorie_id" required>

                @foreach($categories as $categorie)
                    <option
                        value="{{ $categorie->id }}"
                        {{ old('categorie_id', $publication->categorie_id) == $categorie->id ? 'selected' : '' }}
                    >
                        {{ $categorie->nom }}
                    </option>
                @endforeach

            </select>
        </div>

        <button type="submit">Enregistrer les modifications</button>

        <a href="{{ route('contenus.index') }}">Annuler</a>

    </form>

</div>

@endsection