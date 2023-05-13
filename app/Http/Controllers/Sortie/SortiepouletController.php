<?php

namespace App\Http\Controllers\Sortie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SortiepouletController extends Controller
{
    public function page()
    {
        return view('sortie/poulet/page');
    }
}
