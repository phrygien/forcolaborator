<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseCycle extends Model
{
    use HasFactory;

    protected $table = "depense_cycles";

    protected $fillable = [
        'id_cycle',
        'id_depense',
        'id_utilisation',
        'type_depense',
        'qte',
        'valeur'
    ];
}
