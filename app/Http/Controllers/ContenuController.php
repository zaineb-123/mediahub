<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Publication;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;

class ContenuController extends Controller
{
    public function index()
    {
        $publications = Publication::with(['categorie', 'auteur'])
            ->latest()
            ->paginate(9);

        return view('contenus.index', compact('publications'));
    }

    public function create()
    {
        $categories = Categorie::all();

        return view('contenus.create', compact('categories'));
    }

    public function store(StorePublicationRequest $request)
    {
        $publication = Publication::create([
            ...$request->validated(),
            'user_id' => 1,
        ]);

        return redirect()
            ->route('contenus.show', ['contenu' => $publication->id])
            ->with('succes', 'Publication créée avec succès.');
    }

    public function show($contenu)
    {
        $publication = Publication::with(['categorie', 'auteur'])
            ->findOrFail($contenu);

        return view('contenu', compact('publication'));
    }

    public function edit($contenu)
    {
        $publication = Publication::findOrFail($contenu);
        $categories = Categorie::all();

        return view('contenus.edit', compact('publication', 'categories'));
    }

    public function update(UpdatePublicationRequest $request, $contenu)
    {
        $publication = Publication::findOrFail($contenu);

        $publication->update($request->validated());

        return redirect()
            ->route('contenus.show', ['contenu' => $publication->id])
            ->with('succes', 'Publication mise à jour avec succès.');
    }

    public function destroy($contenu)
    {
        $publication = Publication::findOrFail($contenu);

        $publication->delete();

        return redirect()
            ->route('contenus.index')
            ->with('succes', 'Publication supprimée avec succès.');
    }
}
