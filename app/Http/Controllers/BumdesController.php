<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BumdesController extends Controller
{
    public function index()
    {
        return view('bumdes.index');
    }

    public function create()
    {
        return view('bumdes.create');
    }
}
