<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string|min:20',
            'categorie_id' => 'required|exists:categories,id',

            'image' => 'nullable|file|image|max:2048',
            'fichier_media' => 'nullable|file|mimes:mp3,mp4,wav|max:20480',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'contenu.required' => 'Le contenu est obligatoire.',
            'contenu.min' => 'Le contenu doit contenir au moins 20 caractères.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
            'categorie_id.exists' => 'La catégorie sélectionnée est invalide.',

            'image.image' => 'Le fichier doit être une image.',
            'image.max' => 'L’image ne doit pas dépasser 2 Mo.',
            'fichier_media.mimes' => 'Le fichier média doit être au format MP3, MP4 ou WAV.',
            'fichier_media.max' => 'Le fichier média ne doit pas dépasser 20 Mo.',
        ];
    }
}
