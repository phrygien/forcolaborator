<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;
    protected $table = "cycles";

    protected $fillable = [
        'description',
        'id_type_poulet',
        'nb_poulet',
        'id_batiment',
        'date_debut',
        'actif',
        'id_utilisateur',
        'date_arret'
    ];
}
