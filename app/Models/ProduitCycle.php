<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitCycle extends Model
{
    use HasFactory;

    protected $table = 'produit_cycles';

    protected $fillable = [
        'id_cycle',
        'id_produit',
        'id_sortie',
        'qte',
        'pu',
        'valeur'
    ];
}
