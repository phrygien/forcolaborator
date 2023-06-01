<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstatOeuf extends Model
{
    use HasFactory;

    protected $table = "constat_oeufs";

    protected $fillable = [
        'id_type_oeuf',
        'nb',
        'id_cycle',
        'date_entree',
        'id_utilisateur',
        'date_action',
        'nb_disponible'
    ];
}
