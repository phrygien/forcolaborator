<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementCharge extends Model
{
    use HasFactory;

    protected $table = "engagement_charges";

    protected $fillable = [
        'id_depense',
        'pu',
        'qte',
        'prix_total',
        'qte_disponible',
        'date_engagement',
        'retour'
    ];
}
