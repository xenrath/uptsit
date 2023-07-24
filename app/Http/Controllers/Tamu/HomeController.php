<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('tamu.index');
    }
}
