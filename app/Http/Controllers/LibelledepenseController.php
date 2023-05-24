<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LibelledepenseController extends Controller
{
    public function page()
    {
        return view('parametrages/libelle_depense/page');
    }
}
