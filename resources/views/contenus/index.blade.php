
@extends('layouts.app')

@section('titre', 'Liste des publications')

@section('contenu')
<h1>Liste des publications MediaHub</h1>

@auth
    <a href="{{ route('contenus.create') }}">Ajouter une publication</a>
@endauth

@if ($publications->count() > 0)

    @foreach ($publications as $publication)
        <x-carte titre="{{ $publication->titre }}">

            {{-- Afficher la miniature --}}
            @if ($publication->miniature)
                <div style="margin-bottom: 15px;">
                    <img
                        src="{{ asset('storage/' . $publication->miniature) }}"
                        alt="Miniature de {{ $publication->titre }}"
                        style="width: 300px; height: 300px; object-fit: cover; border-radius: 8px;"
                    >
                </div>
            @elseif ($publication->image)
                <div style="margin-bottom: 15px;">
                    <img
                        src="{{ asset('storage/' . $publication->image) }}"
                        alt="{{ $publication->titre }}"
                        style="width: 300px; height: 300px; object-fit: cover; border-radius: 8px;"
                    >
                </div>
            @endif

            <p>{{ $publication->contenu }}</p>

            <p>
                Catégorie :
                {{ $publication->categorie->nom ?? 'Sans catégorie' }}
            </p>

            <p>
                Auteur :
                {{ $publication->auteur->name ?? 'Auteur inconnu' }}
            </p>
            <p>
                Nombre de commentaires :
               {{ $publication->commentaires_count }}
            </p>

            <a href="{{ route('contenus.show', ['contenu' => $publication->id]) }}">
                Lire la publication
            </a>

            @can('update', $publication)
                <a href="{{ route('contenus.edit', ['contenu' => $publication->id]) }}">
                    Modifier
                </a>
            @endcan

            @can('delete', $publication)
                <form
                    method="POST"
                    action="{{ route('contenus.destroy', ['contenu' => $publication->id]) }}"
                    style="display:inline;"
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

        </x-carte>
    @endforeach

@else
    <p>Aucune publication disponible pour le moment.</p>
@endif

<div>
    {{ $publications->links() }}
</div>
@endsection
