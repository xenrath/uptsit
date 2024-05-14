<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hosting;
use Carbon\Carbon;

class HostingController extends Controller
{
    public function index()
    {
        $hostings = Hosting::orderBy('status')->orderByDesc('tanggal_awal')->get();

        return view('admin.hosting.index', compact('hostings'));
    }

    public function show($id)
    {
        $hosting = Hosting::where('id', $id)->first();

        return view('admin.hosting.show', compact('hosting'));
    }

    public function selesai($id)
    {
        Hosting::where('id', $id)->update([
            'status' => 'selesai',
            'tanggal_akhir' => Carbon::now()->format('Y-m-d')
        ]);

        alert()->success('Success', 'Berhasil menyelesaikan permohonan Hosting');

        return back();
    }
}
