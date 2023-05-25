<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilisationdepenseController extends Controller
{
    public function page()
    {
        return view('depense/utilisation/page');
    }
}
