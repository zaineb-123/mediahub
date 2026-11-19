<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $donnees = $request->validated();

        // Enregistrer l'image et générer sa miniature
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');

            // Enregistrer l'image originale
            $donnees['image'] = $imageFile->store(
                'publications',
                'public'
            );

            // Générer une miniature de 300 x 300 pixels
            $manager = new ImageManager(new Driver());

            $image = $manager->read($imageFile->getPathname());
            $image->cover(300, 300);

            // Enregistrer la miniature
            $nomMiniature = 'miniatures/' . uniqid() . '.jpg';

            Storage::disk('public')->put(
                $nomMiniature,
                (string) $image->toJpeg(80)
            );

            $donnees['miniature'] = $nomMiniature;
        }

        // Enregistrer le fichier audio ou vidéo
        if ($request->hasFile('fichier_media')) {
            $fichier = $request->file('fichier_media');

            $donnees['fichier_media'] = $fichier->store(
                'medias',
                'public'
            );

            $donnees['type_media'] = str_starts_with(
                $fichier->getMimeType(),
                'audio/'
            ) ? 'audio' : 'video';
        }

        $donnees['user_id'] = auth()->id();

        $publication = Publication::create($donnees);

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

        $donnees = $request->validated();

        // Remplacer l'image et sa miniature si une nouvelle image est envoyée
        if ($request->hasFile('image')) {

            // Supprimer l'ancienne image
            if ($contenu->image) {
                Storage::disk('public')->delete($contenu->image);
            }

            // Supprimer l'ancienne miniature
            if ($contenu->miniature) {
                Storage::disk('public')->delete($contenu->miniature);
            }

            $imageFile = $request->file('image');

            // Enregistrer la nouvelle image originale
            $donnees['image'] = $imageFile->store(
                'publications',
                'public'
            );

            // Générer la nouvelle miniature
            $manager = new ImageManager(new Driver());

            $image = $manager->read($imageFile->getPathname());
            $image->cover(300, 300);

            // Enregistrer la nouvelle miniature
            $nomMiniature = 'miniatures/' . uniqid() . '.jpg';

            Storage::disk('public')->put(
                $nomMiniature,
                (string) $image->toJpeg(80)
            );

            $donnees['miniature'] = $nomMiniature;
        }

        // Remplacer le fichier audio ou vidéo si nécessaire
        if ($request->hasFile('fichier_media')) {

            if ($contenu->fichier_media) {
                Storage::disk('public')->delete(
                    $contenu->fichier_media
                );
            }

            $fichier = $request->file('fichier_media');

            $donnees['fichier_media'] = $fichier->store(
                'medias',
                'public'
            );

            $donnees['type_media'] = str_starts_with(
                $fichier->getMimeType(),
                'audio/'
            ) ? 'audio' : 'video';
        }

        $contenu->update($donnees);

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
