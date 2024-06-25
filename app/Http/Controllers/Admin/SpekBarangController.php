<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpekBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpekBarangController extends Controller
{
    public function index()
    {
        $spek_barangs = SpekBarang::select('id', 'nama', 'kategori')->get();

        return view('admin.spek.barang.index', compact('spek_barangs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:jenis,merek,model',
            'nama' => 'required',
        ], [
            'kategori.required' => 'Kategori harus dipilih!',
            'kategori.in' => 'Kategori tidak ditemukan!',
            'nama.required' => 'Nama Spesifikasi tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Spesifikasi Barang!');
            return back()->withInput()->withErrors($validator);
        }

        $spek_barang = SpekBarang::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        if (!$spek_barang) {
            alert()->error('Error', 'Gagal menambahkan Spesifikasi Barang!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Spesifikasi Barang');

        return back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:jenis,merek,model',
            'nama' => 'required',
        ], [
            'kategori.required' => 'Kategori harus dipilih!',
            'kategori.in' => 'Kategori tidak ditemukan!',
            'nama.required' => 'Nama Spesifikasi tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Spesifikasi Barang!');
            return back()->withInput()->with('id', $id)->withErrors($validator);
        }

        $spek_barang = SpekBarang::where('id', $id)->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        if (!$spek_barang) {
            alert()->error('Error', 'Gagal memperbarui Spesifikasi Barang!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Spesifikasi Barang');

        return back();
    }

    public function destroy($id)
    {
        $spek_barang = SpekBarang::where('id', $id)->first();
        $spek_barang->delete();

        alert()->success('Success', 'Berhasil menghapus Spesifikasi Barang');

        return back();
    }
}
