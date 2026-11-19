
@extends('layouts.app')

@section('titre', 'Ajouter une publication')

@section('contenu')

<div class="conteneur">

    <h1>Ajouter une publication</h1>

    <form
        action="{{ route('contenus.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

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

        <div>
            <label for="titre">Titre</label>

            <input
                type="text"
                name="titre"
                id="titre"
                value="{{ old('titre', '') }}"
                class="@error('titre') is-invalid @enderror"
                required
            >

            @error('titre')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="contenu">Contenu</label>

            <textarea
                name="contenu"
                id="contenu"
                class="@error('contenu') is-invalid @enderror"
                required
            >{{ old('contenu', '') }}</textarea>

            @error('contenu')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="categorie_id">Catégorie</label>

            <select
                name="categorie_id"
                id="categorie_id"
                class="@error('categorie_id') is-invalid @enderror"
                required
            >
                <option value="">Choisir une catégorie</option>

                @foreach($categories as $categorie)
                    <option
                        value="{{ $categorie->id }}"
                        {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}
                    >
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>

            @error('categorie_id')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        {{-- Image --}}
        <div>
            <label for="image">Image (2 Mo maximum)</label>

            <input
                type="file"
                name="image"
                id="image"
                accept="image/*"
                class="@error('image') is-invalid @enderror"
            >

            @error('image')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        {{-- Fichier audio ou vidéo --}}
        <div>
            <label for="fichier_media">
                Fichier audio ou vidéo (20 Mo maximum)
            </label>

            <input
                type="file"
                name="fichier_media"
                id="fichier_media"
                accept="audio/*,video/mp4"
                class="@error('fichier_media') is-invalid @enderror"
            >

            @error('fichier_media')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Publier</button>

    </form>

</div>

@endsection
