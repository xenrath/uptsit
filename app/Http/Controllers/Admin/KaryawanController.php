<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $paginate = ceil(Karyawan::count() / 7);
        $karyawans = Karyawan::select('id', 'nama', 'telp', 'bagian_id')
            ->with('bagian', function ($query) {
                $query->select('id', 'unit_id', 'sebagai')->with('unit:id,nama');
            })
            ->paginate($paginate);
        $bagians = Bagian::select('id', 'unit_id', 'sebagai')->with('unit:id,nama')->get();

        return view('admin.karyawan.index', compact('karyawans', 'bagians'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required|unique:karyawans,telp',
            'bagian_id' => 'required',
        ], [
            'nama.required' => 'Nama Karyawan tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
            'bagian_id.required' => 'Bagian harus dipilih!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Karyawan!');
            return back()->withInput()->withErrors($validator);
        }

        $karyawan = Karyawan::create([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'bagian_id' => $request->bagian_id,
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
            'telp' => 'required|unique:karyawans,telp,' . $id . ',id',
            'bagian_id' => 'required',
        ], [
            'nama.required' => 'Nama Karyawan tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
            'bagian_id.required' => 'Bagian harus dipilih!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Karyawan!');
            return back()->withInput()->with('id', $id)->withErrors($validator);
        }

        $karyawan = Karyawan::where('id', $id)->update([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'bagian_id' => $request->bagian_id,
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

    // public function import(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required',
    //     ], [
    //         'file.required' => 'Data Karyawan harus ditambahkan!',
    //     ]);

    //     if ($validator->fails()) {
    //         alert()->error('Error', 'Gagal mengimport Karyawan!');
    //         return back()->withInput()->withErrors($validator);
    //     }
    // }
}
