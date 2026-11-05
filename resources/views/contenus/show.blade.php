
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

    <div>
        {{ $publication->contenu }}
    </div>

    @can('update', $publication)
        <a href="{{ route('contenus.edit', ['contenu' => $publication->id]) }}">
            Modifier
        </a>
    @endcan

    @can('delete', $publication)
        <form method="POST"
              action="{{ route('contenus.destroy', ['contenu' => $publication->id]) }}">
            @csrf
            @method('DELETE')

            <button type="submit"
                    onclick="return confirm('Voulez-vous vraiment supprimer cette publication ?')">
                Supprimer
            </button>
        </form>
    @endcan

    <p>
        <a href="{{ route('contenus.index') }}">Retour aux publications</a>
    </p>
</div>
@endsection
