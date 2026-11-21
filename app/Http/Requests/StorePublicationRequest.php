<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PublicationController extends Controller
{
    /**
     * Afficher la liste des publications.
     */
    public function index()
    {
        $publications = Publication::with(['categorie', 'auteur'])
            ->latest()
            ->paginate(10);

        return PublicationResource::collection($publications);
    }

    /**
     * Afficher les détails d'une publication.
     */
    public function show(Publication $publication)
    {
        return new PublicationResource(
            $publication->load(['categorie', 'auteur'])
        );
    }

    /**
     * Créer une nouvelle publication.
     */
    public function store(StorePublicationRequest $request)
    {
        $donnees = $request->validated();

        // Enregistrer l'image et générer sa miniature
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');

            $donnees['image'] = $imageFile->store(
                'publications',
                'public'
            );

            $manager = new ImageManager(new Driver());

            $image = $manager->read($imageFile->getPathname());
            $image->cover(300, 300);

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

        // Associer la publication à l'utilisateur connecté
        $donnees['user_id'] = $request->user()->id;

        $publication = Publication::create($donnees);

        // Charger les relations pour la réponse JSON
        $publication->load(['categorie', 'auteur']);

        return (new PublicationResource($publication))
            ->response()
            ->setStatusCode(201);
    }
}
