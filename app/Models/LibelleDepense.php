<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibelleDepense extends Model
{
    use HasFactory;

    protected $table = "libelle_depenses";

    protected $fillable = [
        'libelle',
        'actif'
    ];
}
