@extends('layouts.app')

@section('titre', 'Inscription')

@section('contenu')
<div class="conteneur">
    <h1>Créer un compte</h1>

    <form action="{{ route('inscription') }}" method="POST">
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
            <label for="name">Nom complet</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                class="@error('name') is-invalid @enderror"
                required
            >
            @error('name')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">Adresse email</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                class="@error('email') is-invalid @enderror"
                required
            >
            @error('email')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input
                type="password"
                name="password"
                id="password"
                class="@error('password') is-invalid @enderror"
                required
            >
            @error('password')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                required
            >
        </div>

        <button type="submit">S'inscrire</button>

        <p>
            Déjà inscrit ?
            <a href="{{ route('connexion') }}">Se connecter</a>
        </p>
    </form>
</div>
@endsection
