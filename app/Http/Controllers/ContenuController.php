<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Http\Request;

class ContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

public function store(Request $request)
{
    $publication = Publication::create([
        'titre' => $request->input('titre'),
        'contenu' => $request->input('contenu'),
        'categorie_id' => $request->input('categorie_id'),
        'user_id' => 1,
    ]);

    return redirect()
        ->route('contenus.show', $publication)
        ->with('succes', 'Publication créée avec succès.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('contenu', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit($contenu)
{
    $publication = Publication::findOrFail($contenu);
    $categories = Categorie::all();

    return view('contenus.edit', compact('publication', 'categories'));
}

public function update(Request $request, $contenu)
{
    $publication = Publication::findOrFail($contenu);

    $request->validate([
        'titre' => 'required|string|max:255',
        'contenu' => 'required|string',
        'categorie_id' => 'required|exists:categories,id',
    ]);

    $publication->update($request->only([
        'titre',
        'contenu',
        'categorie_id'
    ]));

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
