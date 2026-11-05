@extends('layouts.app')

@section('titre', 'Connexion')

@section('contenu')
<div class="conteneur">
    <h1>Se connecter</h1>

    <form action="{{ route('connexion') }}" method="POST">
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

        <button type="submit">Se connecter</button>

        <p>
            Pas encore de compte ?
            <a href="{{ route('inscription') }}">Créer un compte</a>
        </p>
    </form>
</div>
@endsection
