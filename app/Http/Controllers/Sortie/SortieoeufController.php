<?php

namespace App\Http\Controllers\Sortie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SortieoeufController extends Controller
{
    public function page()
    {
        return view('sortie/oeuf/page');
    }
}
