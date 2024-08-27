<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    // Si le nom de votre table n'est pas le pluriel du nom du modèle, spécifiez-le ici.
    protected $table = 'vocabularies';

    // Les attributs que vous pouvez mass-assigner.
    protected $fillable = [
        'is_sentence',
        'french',
        'serere',
        'correctly_translated',
        'correctly_understoord',
    ];
}
