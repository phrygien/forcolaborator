<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstatPoulard extends Model
{
    use HasFactory;

    protected $table = "constat_poulards";

    protected $fillable = [
        'id_cycle',
        'nb',
        'date_constat',
        'nb_disponible',
        'retour'
    ]; 
}
