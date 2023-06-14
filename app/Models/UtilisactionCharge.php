<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilisactionCharge extends Model
{
    use HasFactory;

    protected $table = "utilisaction_charges";

    protected $fillable = [
        'id_depense',
        'id_site',
        'id_cycle',
        'qte',
        'date_utilisation',
        'id_utilisateur',
        'avec_retour'
    ];
}
