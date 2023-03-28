<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class MenungguController extends Controller
{
    public function menunggu()
    {
        $pengaduans = Pengaduan::get();
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function konfirmasi_proses()
    {
        
    }
}
