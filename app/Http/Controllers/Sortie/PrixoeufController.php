<?php

namespace App\Http\Controllers\Sortie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrixoeufController extends Controller
{
    public function page()
    {
        return view('sortie/prix_oeuf/page');
    }
}
