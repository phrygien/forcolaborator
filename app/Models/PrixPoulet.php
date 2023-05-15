<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrixPoulet extends Model
{
    use HasFactory;

    protected $table = "prix_poulets";

    protected $fillable = [
        'id_type_poulet',
        'date_application',
        'pu_kg',
        'actif',
        'id_utilisateur',
    ];
}
