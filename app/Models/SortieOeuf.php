<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortieOeuf extends Model
{
    use HasFactory;

    protected $table = "sortie_oeufs";

    protected $fillable = [
        'id_type_oeuf',
        'id_type_sortie',
        'qte',
        'pu',
        'montant',
        'actif',
        'id_utilisateur',
        'date_action',
        'id_client',
        'date_sortie',
    ];
}
