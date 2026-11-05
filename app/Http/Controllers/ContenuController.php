<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContenuController extends Controller
{
    use AuthorizesRequests;

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
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('contenus.show', ['contenu' => $publication->id])
            ->with('succes', 'Publication créée avec succès.');
    }

    public function show(Publication $contenu)
    {
        $publication = $contenu->load(['categorie', 'auteur']);

        return view('contenus.show', compact('publication'));
    }

    public function edit(Publication $contenu)
    {
        $this->authorize('update', $contenu);

        $publication = $contenu;
        $categories = Categorie::all();

        return view('contenus.edit', compact('publication', 'categories'));
    }

    public function update(
        UpdatePublicationRequest $request,
        Publication $contenu
    ) {
        $this->authorize('update', $contenu);

        $contenu->update($request->validated());

        return redirect()
            ->route('contenus.show', ['contenu' => $contenu->id])
            ->with('succes', 'Publication mise à jour avec succès.');
    }

    public function destroy(Publication $contenu)
    {
        $this->authorize('delete', $contenu);

        $contenu->delete();

        return redirect()
            ->route('contenus.index')
            ->with('succes', 'Publication supprimée avec succès.');
    }
}
