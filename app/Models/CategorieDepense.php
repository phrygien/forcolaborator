<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieDepense extends Model
{
    use HasFactory;

    protected $table = "categorie_depenses";

    protected $fillable = [
        'categorie',
        'commentaire',
        'actif'
    ];

}
