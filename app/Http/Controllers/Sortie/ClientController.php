<?php

namespace App\Http\Controllers\Sortie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function page()
    {
        return view('sortie/client/page');
    }
}
