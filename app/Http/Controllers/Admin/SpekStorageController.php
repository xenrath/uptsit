<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpekStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpekStorageController extends Controller
{
    public function index()
    {
        $spek_storages = SpekStorage::select('id', 'nama', 'kategori')->get();

        return view('admin.spek.storage.index', compact('spek_storages'));
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
            alert()->error('Error', 'Gagal menambahkan Spesifikasi Storage!');
            return back()->withInput()->withErrors($validator);
        }

        $spek_storage = SpekStorage::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        if (!$spek_storage) {
            alert()->error('Error', 'Gagal menambahkan Spesifikasi Storage!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Spesifikasi Storage');

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
            alert()->error('Error', 'Gagal memperbarui Spesifikasi Storage!');
            return back()->withInput()->with('id', $id)->withErrors($validator);
        }

        $spek_storage = SpekStorage::where('id', $id)->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        if (!$spek_storage) {
            alert()->error('Error', 'Gagal memperbarui Spesifikasi Storage!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Spesifikasi Storage');

        return back();
    }

    public function destroy($id)
    {
        $spek_storage = SpekStorage::where('id', $id)->first();
        $spek_storage->delete();

        alert()->success('Success', 'Berhasil menghapus Spesifikasi Storage');

        return back();
    }
}
