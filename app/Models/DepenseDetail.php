<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseDetail extends Model
{
    use HasFactory;

    protected $table = "depense_details";
    
    protected $fillable = [
        'id_cycle',
        'id_utilisation',
        'type_depense',
        'qte',
        'valeur'
    ];
}
