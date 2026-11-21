<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use Illuminate\Support\Facades\Cache;

class CategorieController extends Controller
{
    /**
     * Afficher la liste des catégories avec le nombre de publications.
     * Les résultats sont conservés en cache pendant une heure.
     */
    public function index()
    {
        $categories = Cache::remember(
            'categories_liste',
            3600,
            function () {
                return Categorie::withCount('publications')->get();
            }
        );

        return view('categories.index', compact('categories'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Enregistrer une nouvelle catégorie.
     */
    public function store(StoreCategorieRequest $request)
    {
        Categorie::create($request->validated());

        Cache::forget('categories_liste');

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie créée avec succès.');
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Mettre à jour une catégorie.
     */
    public function update(
        UpdateCategorieRequest $request,
        Categorie $categorie
    ) {
        $categorie->update($request->validated());

        Cache::forget('categories_liste');

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprimer une catégorie.
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        Cache::forget('categories_liste');

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie supprimée avec succès.');
    }
}
