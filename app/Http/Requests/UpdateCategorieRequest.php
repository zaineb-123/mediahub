<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategorieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->ignore($this->route('categorie')),
            ],
        ];
    }
    public function messages(): array
{
    return [
        'slug.unique' => 'Ce slug existe déjà. Choisissez un autre slug.',
        'slug.required' => 'Le slug est obligatoire.',
        'nom.required' => 'Le nom de la catégorie est obligatoire.',
    ];
}
}