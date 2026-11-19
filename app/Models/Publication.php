<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Publication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'titre',
    'contenu',
    'categorie_id',
    'user_id',
    'image',
    'miniature',
    'fichier_media',
    'type_media',
    ];
    public function categorie()
{
    return $this->belongsTo(Categorie::class);
}
public function auteur()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function commentaires()
{
    return $this->hasMany(Commentaire::class);
}
protected static function booted(): void
{
    static::deleting(function (Publication $publication) {
        if ($publication->isForceDeleting()) {
            if ($publication->image) {
                Storage::disk('public')->delete($publication->image);
            }

            if ($publication->miniature) {
                Storage::disk('public')->delete($publication->miniature);
            }

            if ($publication->fichier_media) {
                Storage::disk('public')->delete($publication->fichier_media);
            }
        }
    });
}
}
