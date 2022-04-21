<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [];
        return view('dashboard', $data);
    }

    public function landing_page()
    {
        return view('landing-page.index');
    }
}
