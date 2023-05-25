<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilisationDepenese extends Model
{
    use HasFactory;

    protected $table = "utilisation_depenses";

    protected $fillable = [
        'date_utilisation',
        'qte',
        'montant',
        'utilisation_cicble',
        'id_depense_brut',  
    ];
}
