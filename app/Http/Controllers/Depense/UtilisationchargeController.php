<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilisationchargeController extends Controller
{
    public function page()
    {
        return view('depense/utilisation_charge/page');
    }
}
