<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcquisitionController extends Controller
{
    public function page()
    {
        return view('depense/acquisition/page');
    }
}
