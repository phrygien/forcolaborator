<?php

namespace App\Http\Controllers\Entree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConstatpoulardController extends Controller
{
    public function page()
    {
        return view('gestion_entrees/constat_poulard/page');
    }   
}
