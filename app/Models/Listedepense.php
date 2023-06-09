<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listedepense extends Model
{
    use HasFactory;
    
    protected $table = "listedepenses";

    protected $fillable = [
        'nom_depense',
        'id_unite',
        'cycle_concerne', // 1: poulet de chaire, 2:Poules pondeuse, 3: depense communes
        'affectation', // 1: dépense commune de ferme, 2: dépense commune de site, 3: dépense specifiques de cycle
        'type', // 1:charges, 2: Immobilisations
        'nb_annee_amortissement',
        'actif'
    ];
}
