@extends('layouts.app')

@section('titre', 'Liste des contenus')

@section('contenu')

    <h1>Liste des contenus MediaHub</h1>

    @forelse ($contenus as $contenu)

        <x-carte titre="{{ $contenu->titre }}">

            <p>{{ $contenu->description }}</p>

        </x-carte>

    @empty

        <p>Aucun contenu disponible pour le moment.</p>

    @endforelse

@endsection