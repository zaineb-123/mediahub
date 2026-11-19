
@extends('layouts.app')

@section('titre', $publication->titre)

@section('contenu')

<div class="conteneur">

    <h1>{{ $publication->titre }}</h1>

    <p>
        Catégorie :
        {{ $publication->categorie->nom ?? 'Sans catégorie' }}
    </p>

    <p>
        Auteur :
        {{ $publication->auteur->name ?? 'Auteur inconnu' }}
    </p>

    {{-- Contenu de la publication --}}
    <div>
        {{ $publication->contenu }}
    </div>

    {{-- Affichage de l'image --}}
    @if ($publication->image)
        <div>
            <h3>Image</h3>

            <img
                src="{{ \Illuminate\Support\Facades\Storage::url($publication->image) }}"
                alt="Image de {{ $publication->titre }}"
                style="max-width: 100%; max-height: 450px; height: auto;"
            >
        </div>
    @endif

    {{-- Affichage du fichier audio ou vidéo --}}
    @if ($publication->fichier_media)

        <div>
            <h3>
                {{ $publication->type_media === 'audio' ? 'Fichier audio' : 'Vidéo' }}
            </h3>

            @if ($publication->type_media === 'audio')

                <audio controls style="max-width: 100%;">
                    <source
                        src="{{ \Illuminate\Support\Facades\Storage::url($publication->fichier_media) }}"
                    >
                    Votre navigateur ne prend pas en charge la lecture audio.
                </audio>

            @elseif ($publication->type_media === 'video')

                <video controls style="max-width: 100%; max-height: 450px;">
                    <source
                        src="{{ \Illuminate\Support\Facades\Storage::url($publication->fichier_media) }}"
                    >
                    Votre navigateur ne prend pas en charge la lecture vidéo.
                </video>

            @endif
        </div>

    @endif

    {{-- Bouton Modifier --}}
    @can('update', $publication)
        <a href="{{ route('contenus.edit', ['contenu' => $publication->id]) }}">
            Modifier
        </a>
    @endcan

    {{-- Bouton Supprimer --}}
    @can('delete', $publication)
        <form
            method="POST"
            action="{{ route('contenus.destroy', ['contenu' => $publication->id]) }}"
        >
            @csrf
            @method('DELETE')

            <button
                type="submit"
                onclick="return confirm('Voulez-vous vraiment supprimer cette publication ?')"
            >
                Supprimer
            </button>
        </form>
    @endcan

    <p>
        <a href="{{ route('contenus.index') }}">
            Retour aux publications
        </a>
    </p>

</div>

@endsection
