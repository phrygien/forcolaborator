<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrixOeuf extends Model
{
    use HasFactory;

    protected $table = "prix_oeufs";

    protected $fillable = [
        'id_type_oeuf',
        'date_application',
        'pu',
        'actif',
        'id_utilisateur',
    ];
}
