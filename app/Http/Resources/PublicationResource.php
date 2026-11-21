<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'contenu' => $this->contenu,

            'categorie' => $this->categorie
                ? $this->categorie->nom
                : null,

            'auteur' => $this->auteur
                ? $this->auteur->name
                : null,

            'image' => $this->image
                ? Storage::disk('public')->url($this->image)
                : null,

            'miniature' => $this->miniature
                ? Storage::disk('public')->url($this->miniature)
                : null,

            'fichier_media' => $this->fichier_media
                ? Storage::disk('public')->url($this->fichier_media)
                : null,

            'type_media' => $this->type_media,

            'publie_le' => $this->created_at?->toDateString(),
        ];
    }
}
