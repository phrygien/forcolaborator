<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstatPoulet extends Model
{
    use HasFactory;

    protected $table = "constat_poulets";

    protected $fillable = [
        'nb',
        'id_cycle',
        'date_constat',
        'id_utilisateur',
        'nb_disponible',
        'retour',
        'date_action'
    ];
}
