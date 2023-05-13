<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortiePoulet extends Model
{
    use HasFactory;

    protected $table = "sortie_poulets";

    protected $fillable = [
        'id_type_poulet',
        'id_type_sortie',
        'poids_total',
        'nombre',
        'prix_unite',
        'date_sortie',
        'id_client',
        'id_utilisateur',
        'date_action',
        'actif'
    ];
}
