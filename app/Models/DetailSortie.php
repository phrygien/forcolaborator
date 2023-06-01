<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSortie extends Model
{
    use HasFactory;

    protected $table = "detail_sorties";

    protected $fillable = [
        'id_sortie',
        'id_constat',
        'id_produit',
        'qte',
        'valeur',
        'pu'
    ];
}
