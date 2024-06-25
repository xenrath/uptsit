<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::select('id', 'nama', 'telp')->get();

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required|unique:users,telp',
        ], [
            'nama.required' => 'Nama Karyawan tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Karyawan!');
            return back()->withInput()->withErrors($validator);
        }

        $karyawan = Karyawan::create([
            'nama' => $request->nama,
            'telp' => $request->telp,
        ]);

        if (!$karyawan) {
            alert()->error('Error', 'Gagal menambahkan Karyawan!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Karyawan');

        return back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required|unique:users,telp',
        ], [
            'nama.required' => 'Nama Karyawan tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Karyawan!');
            return back()->withInput()->with('id', $id)->withErrors($validator);
        }

        $karyawan = Karyawan::where('id', $id)->update([
            'nama' => $request->nama,
            'telp' => $request->telp,
        ]);

        if (!$karyawan) {
            alert()->error('Error', 'Gagal memperbarui Karyawan!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Karyawan');

        return back();
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::where('id', $id)->first();
        $karyawan->delete();

        alert()->success('Success', 'Berhasil menghapus Karyawan');

        return back();
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ], [
            'file.required' => 'Data Karyawan harus ditambahkan!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal mengimport Karyawan!');
            return back()->withInput()->withErrors($validator);
        }

        
    }
}
