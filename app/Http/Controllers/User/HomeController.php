<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::where('user_id', auth()->user()->id)->count();

        return view('user.index', compact('kegiatan'));
    }
}
