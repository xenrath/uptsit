<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IdentitasController extends Controller
{
    public function index()
    {
        $identitas = Identitas::select(
            'nama',
            'deskripsi',
            'sistem',
            'website',
            'ap',
            'email',
            'telp',
            'visi',
            'misi'
        )
            ->first();

        return view('admin.identitas.index', compact('identitas'));
    }

    public function update(Request $request)
    {
        return view('error.500');

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'sistem' => 'required',
            'website' => 'required',
            'ap' => 'required',
            'email' => 'required',
            'telp' => 'required',
        ], [
            'nama.required'  => 'Nama Unit harus diisi!',
            'deskripsi.required' => 'Deskripsi harus diisi!',
            'sistem.required' => 'Jumlah sistem harus diisi!',
            'website.required' => 'Jumlah website harus diisi!',
            'ap.required' => 'Jumlah akses point harus diisi!',
            'email.required' => 'Email harus diisi!',
            'telp.required' => 'No. Telepon harus diisi!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Identitas Unit!');
            return back()->withInput()->withErrors($validator);
        }

        Identitas::first()->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'sistem' => $request->sistem,
            'website' => $request->website,
            'ap' => $request->ap,
            'email' => $request->email,
            'telp' => $request->telp,
        ]);

        alert()->success('Success', 'Berhasil memperbarui Identitas Unit');

        return back();
    }
}
