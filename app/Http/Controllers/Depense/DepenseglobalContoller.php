<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepenseglobalContoller extends Controller
{
    public function page()
    {
        return view('depense/global/page');
    }
}
