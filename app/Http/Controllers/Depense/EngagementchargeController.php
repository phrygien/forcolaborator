<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EngagementchargeController extends Controller
{
    public function page()
    {
        return view('depense/engagement_charge/page');
    }
}
