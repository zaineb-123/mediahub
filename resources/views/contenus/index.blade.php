@extends('layouts.app')

@section('titre', 'Liste des publications')

@section('contenu')

<h1>Liste des publications MediaHub</h1>

<a href="{{ route('contenus.create') }}">
    Ajouter une publication
</a>

@if($publications->count() > 0)

    @foreach ($publications as $publication)

        <x-carte titre="{{ $publication->titre }}">

            <p>{{ $publication->contenu }}</p>

            <p>
                Catégorie :
                {{ $publication->categorie->nom ?? 'Sans catégorie' }}
            </p>

            <p>
                Auteur :
                {{ $publication->auteur->name ?? 'Auteur inconnu' }}
            </p>
    <a href="{{ route('contenus.edit', ['contenu' => $publication->id]) }}">
        Modifier
    </a>

    <form method="POST"
        action="{{ route('contenus.destroy', ['contenu' => $publication->id]) }}"
        style="display:inline;">

        @csrf
        @method('DELETE')

        <button type="submit"
                onclick="return confirm('Voulez-vous vraiment supprimer cette publication ?')">
            Supprimer
        </button>
    </form>

        </x-carte>

    @endforeach

@else

    <p>Aucune publication disponible pour le moment.</p>

@endif

<div>
    {{ $publications->links() }}
</div>

@endsection