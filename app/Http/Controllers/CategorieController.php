<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('publications')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
    ], [
        'slug.unique' => 'Ce slug existe déjà. Choisissez un autre slug.',
    ]);

    Categorie::create($request->only('nom', 'slug'));

    return redirect()
        ->route('categories.index')
        ->with('succes', 'Catégorie créée avec succès.');
}

        public function edit(Categorie $categorie)
    {
    return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug,' . $categorie->id,
    ]);

    $categorie->update($request->only('nom', 'slug'));

    return redirect()
        ->route('categories.index')
        ->with('succes', 'Catégorie mise à jour avec succès.');
}


        public function destroy(Categorie $categorie)
    {
    $categorie->delete();
    return redirect()
    ->route('categories.index')
    ->with('succes', 'Catégorie supprimée avec succès.');
    }

}