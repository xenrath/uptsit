<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $unit = Unit::select(
            'nama',
            'deskripsi',
            'sistem',
            'website',
            'ap',
            'email',
            'telp'
        )
            ->first();

        return view('admin.unit.index', compact('unit'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'sistem' => 'required',
            'website' => 'required',
            'ap' => 'required',
            'email' => 'required',
            'telp' => 'required',
        ], [
            'nama.required'  => 'Nama Unit harus ditambahkan!',
            'deskripsi.required' => 'Deskripsi harus diisi!',
            'sistem.required' => 'Jumlah sistem harus diisi!',
            'website.required' => 'Jumlah website harus diisi!',
            'ap.required' => 'Jumlah akses point harus diisi!',
            'email.required' => 'Email harus ditambahkan!',
            'telp.required' => 'No. Telepon harus ditambahkan!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            alert()->error('Error', 'Gagal memperbarui Identitas Unit!');
            return back()->withInput()->withError('error', $error);
        }

        Unit::first()->update([
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
