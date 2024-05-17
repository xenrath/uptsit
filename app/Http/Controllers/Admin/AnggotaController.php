<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::get();
        return view('admin.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required|unique:anggotas,telp',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nama.required' => 'Nama Anggota tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
            'foto.image' => 'Foto harus berformat jpeg, jpg, png!',
            'foto.max' => 'Foto maksimal ukuran 2 MB',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = date('YmdHis');

        if ($request->foto) {
            $foto = 'anggota/' . $kode . '_' . random_int(10, 99) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto);
        } else {
            $foto = null;
        }

        Anggota::create([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'foto' => $foto
        ]);

        alert()->success('Success', 'Berhasil menambahkan Anggota');

        return redirect('admin/anggota');
    }

    public function edit($id)
    {
        $anggota = Anggota::where('id', $id)->first();
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required|unique:anggotas,telp,' . $id . ',id',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nama.required' => 'Nama Anggota tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
            'foto.image' => 'Foto harus berformat jpeg, jpg, png!',
            'foto.max' => 'Foto maksimal ukuran 2 MB',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = date('YmdHis');

        if ($request->foto) {
            Storage::disk('local')->delete('public/uploads/' . $request->foto);
            $foto = 'anggota/' . $kode . '_' . random_int(10, 99) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto);
        } else {
            $foto = Anggota::where('id', $id)->value('foto');
        }

        if ($request->is_petugas == 'on') {
            Anggota::where('is_petugas', true)->update([
                'is_petugas' => false,
            ]);
            $is_petugas = true;
        } else {
            $is_petugas = false;
        }

        Anggota::where('id', $id)->update([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'foto' => $foto,
            'is_petugas' => $is_petugas
        ]);

        alert()->success('Success', 'Berhasil memperbarui Anggota');

        return redirect('admin/anggota');
    }

    public function destroy($id)
    {
        $anggota = Anggota::where('id', $id)->first();
        Storage::disk('local')->delete('public/uploads/' . $anggota->foto);
        $anggota->delete();

        alert()->success('Success', 'Berhasil menghapus Anggota');

        return back();
    }
}
