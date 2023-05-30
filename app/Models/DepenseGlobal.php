<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseGlobal extends Model
{
    use HasFactory;

    protected $table = "depense_globals";

    protected $fillable = [
        'id_libelle_depense',
        'id_type_depense',
        'date_entree',
        'qte',
        'montant_total',
        'id_utilisateur'
    ];
}
