<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengaduanController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Pengaduan');
        return view('pengaduan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'unit' => 'required',
            'deskripsi' => 'required',
        ], [
            'nama.required'  => 'Nama pengadu harus ditambahkan!',
            'unit.required' => 'Unit / bagian harus ditambahkan!',
            'deskripsi.required' => 'Deskripsi harus diisi!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Pengaduan::create(array_merge($request->all(), [
            'status' => 'menunggu'
        ]));

        return back()->with('success', 'Berhasil membuat Pengaduan');
    }
}
