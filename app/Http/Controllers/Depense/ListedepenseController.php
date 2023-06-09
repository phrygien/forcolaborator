<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListedepenseController extends Controller
{
    public function page()
    {
        return view('depense/liste_depense/page');
    }
}
