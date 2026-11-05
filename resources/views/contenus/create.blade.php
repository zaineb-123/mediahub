@extends('layouts.app')

@section('titre', 'Ajouter une publication')

@section('contenu')

<div class="conteneur">

    <h1>Ajouter une publication</h1>

    <form action="{{ route('contenus.store') }}" method="POST">

        @csrf

        <div>
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre"
                   value="{{ old('titre') }}" required>
        </div>

        <div>
            <label for="contenu">Contenu</label>
            <textarea name="contenu" id="contenu" required>{{ old('contenu') }}</textarea>
        </div>

        <div>
            <label for="categorie_id">Catégorie</label>

            <select name="categorie_id" id="categorie_id" required>
                <option value="">Choisir une catégorie</option>

                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}"
                        {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Publier</button>

    </form>

</div>

@endsection