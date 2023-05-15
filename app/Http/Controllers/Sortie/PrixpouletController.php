<?php

namespace App\Http\Controllers\Sortie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrixpouletController extends Controller
{
    public function page()
    {
        return view('sortie/prix_poulet/page');
    }
}
