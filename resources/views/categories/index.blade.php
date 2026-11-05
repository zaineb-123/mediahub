
@extends('layouts.app')

@section('contenu')

<div class="container">

    <h1>Liste des catégories</h1>

    @if(session('succes'))
        <div class="alert alert-success">
            {{ session('succes') }}
        </div>
    @endif

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
        Ajouter une catégorie
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Slug</th>
                <th>Nombre de publications</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($categories as $categorie)
                <tr>
                    <td>{{ $categorie->id }}</td>
                    <td>{{ $categorie->nom }}</td>
                    <td>{{ $categorie->slug }}</td>
                    <td>{{ $categorie->publications_count }}</td>
                    <td>
    <div style="display: flex; align-items: center; gap: 10px;">

        <a href="{{ route('categories.edit', ['categorie' => $categorie->id]) }}"
           class="btn btn-primary">
            Modifier
        </a>

        <form action="{{ route('categories.destroy', ['categorie' => $categorie->id]) }}"
              method="POST"
              style="margin: 0;">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                Supprimer
            </button>

        </form>

    </div>
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucune catégorie disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
