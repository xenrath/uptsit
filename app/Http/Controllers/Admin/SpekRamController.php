<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpekRam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpekRamController extends Controller
{
    public function index()
    {
        $spek_rams = SpekRam::select('id', 'nama', 'kategori')->get();

        return view('admin.spek.ram.index', compact('spek_rams'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:tipe,merek',
            'nama' => 'required',
        ], [
            'kategori.required' => 'Kategori harus dipilih!',
            'kategori.in' => 'Kategori tidak ditemukan!',
            'nama.required' => 'Nama Spesifikasi tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Spesifikasi RAM!');
            return back()->withInput()->withErrors($validator);
        }

        $spek_ram = SpekRam::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        if (!$spek_ram) {
            alert()->error('Error', 'Gagal menambahkan Spesifikasi RAM!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Spesifikasi RAM');

        return back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:tipe,merek',
            'nama' => 'required',
        ], [
            'kategori.required' => 'Kategori harus dipilih!',
            'kategori.in' => 'Kategori tidak ditemukan!',
            'nama.required' => 'Nama Spesifikasi tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Spesifikasi RAM!');
            return back()->withInput()->with('id', $id)->withErrors($validator);
        }

        $spek_ram = SpekRam::where('id', $id)->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        if (!$spek_ram) {
            alert()->error('Error', 'Gagal memperbarui Spesifikasi RAM!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Spesifikasi RAM');

        return back();
    }

    public function destroy($id)
    {
        $spek_ram = SpekRam::where('id', $id)->first();
        $spek_ram->delete();

        alert()->success('Success', 'Berhasil menghapus Spesifikasi RAM');

        return back();
    }
}
