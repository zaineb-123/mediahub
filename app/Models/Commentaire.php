<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'publication_id',
        'user_id',
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }

    public function auteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}