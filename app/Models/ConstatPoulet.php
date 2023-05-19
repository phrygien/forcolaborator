<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstatPoulet extends Model
{
    use HasFactory;

    protected $table = "constat_poulets";

    protected $fillable = [
        'poids_moyen',
        'id_cycle',
        'date_constat',
        'id_utilisateur',
        'date_action'
    ];
}
