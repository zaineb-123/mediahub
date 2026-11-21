<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class PublicationController extends Controller
{
    use AuthorizesRequests;
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
     * Créer une publication.
     */
    public function store(StorePublicationRequest $request)
    {
        $donnees = $request->validated();

        // Enregistrer l'image et générer sa miniature.
        if ($request->hasFile('image')) {
            $images = $this->enregistrerImage($request->file('image'));

            $donnees['image'] = $images['image'];
            $donnees['miniature'] = $images['miniature'];
        }

        // Enregistrer le fichier audio ou vidéo.
        if ($request->hasFile('fichier_media')) {
            $media = $this->enregistrerMedia(
                $request->file('fichier_media')
            );

            $donnees['fichier_media'] = $media['chemin'];
            $donnees['type_media'] = $media['type'];
        }

        // Associer la publication à l'utilisateur connecté.
        $donnees['user_id'] = $request->user()->id;

        $publication = Publication::create($donnees);

        return (new PublicationResource(
            $publication->load(['categorie', 'auteur'])
        ))->response()->setStatusCode(201);
    }

    /**
     * Modifier une publication.
     */
    public function update(
        UpdatePublicationRequest $request,
        Publication $publication
    ) {
        $this->authorize('update', $publication);

        $donnees = $request->validated();

        // Remplacer l'image si une nouvelle image est envoyée.
        if ($request->hasFile('image')) {
            $ancienneImage = $publication->image;
            $ancienneMiniature = $publication->miniature;

            $images = $this->enregistrerImage($request->file('image'));

            $donnees['image'] = $images['image'];
            $donnees['miniature'] = $images['miniature'];

            if ($ancienneImage) {
                Storage::disk('public')->delete($ancienneImage);
            }

            if ($ancienneMiniature) {
                Storage::disk('public')->delete($ancienneMiniature);
            }
        }

        // Remplacer le fichier audio ou vidéo si nécessaire.
        if ($request->hasFile('fichier_media')) {
            $ancienMedia = $publication->fichier_media;

            $media = $this->enregistrerMedia(
                $request->file('fichier_media')
            );

            $donnees['fichier_media'] = $media['chemin'];
            $donnees['type_media'] = $media['type'];

            if ($ancienMedia) {
                Storage::disk('public')->delete($ancienMedia);
            }
        }

        $publication->update($donnees);

        return new PublicationResource(
            $publication->fresh()->load(['categorie', 'auteur'])
        );
    }

    /**
     * Supprimer une publication.
     */
    public function destroy(Publication $publication)
    {
        $this->authorize('delete', $publication);

        $publication->delete();

        return response()->json(null, 204);
    }

    /**
     * Enregistrer une image et créer sa miniature.
     */
    private function enregistrerImage(UploadedFile $fichier): array
    {
        $cheminImage = $fichier->store('publications', 'public');

        $manager = new ImageManager(new Driver());

        $image = $manager->read($fichier->getPathname())
            ->cover(300, 300);

        $cheminMiniature = 'miniatures/' . uniqid() . '.jpg';

        Storage::disk('public')->put(
            $cheminMiniature,
            (string) $image->toJpeg(80)
        );

        return [
            'image' => $cheminImage,
            'miniature' => $cheminMiniature,
        ];
    }

    /**
     * Enregistrer un fichier audio ou vidéo.
     */
    private function enregistrerMedia(UploadedFile $fichier): array
    {
        $chemin = $fichier->store('medias', 'public');

        $mime = $fichier->getMimeType();

        $type = str_starts_with($mime, 'video/')
            ? 'video'
            : (str_starts_with($mime, 'audio/') ? 'audio' : null);

        return [
            'chemin' => $chemin,
            'type' => $type,
        ];
    }
}
