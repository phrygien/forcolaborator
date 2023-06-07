<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UniteController extends Controller
{
    public function page()
    {
        return view('depense/unite/page');
    }
}
