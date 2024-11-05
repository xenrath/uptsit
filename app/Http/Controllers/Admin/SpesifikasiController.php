<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spesifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpesifikasiController extends Controller
{
    public function index()
    {
        $spesifikasis = Spesifikasi::select(
            'id',
            'kategori',
            'grup',
            'keterangan'
        )
            ->get()
            ->sortBy('keterangan')
            ->sortBy('grup')
            ->sortBy('kategori');

        return view('admin.spesifikasi.index', compact('spesifikasis'));
    }

    public function store(Request $request)
    {
        if ($request->kategori == 'motherboard') {
            $in_grup = 'merek';
        } elseif ($request->kategori == 'prosesor') {
            $in_grup = 'model';
        } elseif ($request->kategori == 'ram') {
            $in_grup = 'tipe,merek,kapasitas';
        } elseif ($request->kategori == 'storage') {
            $in_grup = 'merek,kapasitas';
        } else {
            $in_grup = '';
        }
        if ($request->grup == 'kapasitas') {
            $is_kapasitas = '|numeric';
        } else {
            $is_kapasitas = '';
        }

        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:motherboard,prosesor,ram,storage',
            'grup' => 'required|in:' . $in_grup,
            'keterangan' => 'required' . $is_kapasitas,
        ], [
            'kategori.required' => 'Kategori harus dipilih!',
            'kategori.in' => 'Kategori tidak ditemukan!',
            'grup.required' => 'Grup harus dipilih!',
            'grup.in' => 'Grup tidak ditemukan!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'keterangan.numeric' => 'Keterangan yang dimasukan salah!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Spesifikasi!');
            return back()->withInput()->withErrors($validator);
        }

        $spesifikasi = Spesifikasi::create([
            'kategori' => $request->kategori,
            'grup' => $request->grup,
            'keterangan' => $request->keterangan,
        ]);

        if (!$spesifikasi) {
            alert()->error('Error', 'Gagal menambahkan Spesifikasi!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Spesifikasi');

        return back();
    }

    public function update(Request $request, $id)
    {
        if (Spesifikasi::where('id', $id)->value('grup') == 'kapasitas') {
            $is_kapasitas = '|numeric';
        } else {
            $is_kapasitas = '';
        }
        $validator = Validator::make($request->all(), [
            'edit_keterangan' => 'required' . $is_kapasitas,
        ], [
            'edit_keterangan.required' => 'Keterangan harus diisi!',
            'edit_keterangan.numeric' => 'Keterangan yang dimasukan salah!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Spesifikasi!');
            return back()->withInput()->with('id', $id)->withErrors($validator);
        }

        $spesifikasi = Spesifikasi::where('id', $id)->update([
            'keterangan' => $request->edit_keterangan,
        ]);

        if (!$spesifikasi) {
            alert()->error('Error', 'Gagal memperbarui Spesifikasi!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Spesifikasi');

        return back();
    }

    public function destroy($id)
    {
        $spesifikasi = Spesifikasi::where('id', $id)->delete();

        if (!$spesifikasi) {
            alert()->error('Error', 'Gagal menghapus Spesifikasi!');
            return back();
        }

        alert()->success('Success', 'Berhasil menghapus Spesifikasi');

        return back();
    }
}
