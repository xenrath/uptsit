<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->select('id', 'nama', 'telp', 'bagian')
            ->get();

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required|unique:users,telp',
            'bagian' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nama.required' => 'Nama Anggota tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
            'bagian.required' => 'Bagian harus dipilih!',
            'foto.image' => 'Foto harus berformat jpeg, jpg, png!',
            'foto.max' => 'Foto maksimal ukuran 2 MB',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Anggota!');
            return back()->withInput()->withErrors($validator);
        }

        $kode = date('YmdHis');

        if ($request->foto) {
            $foto = 'user/' . $kode . '_' . random_int(10, 99) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto);
        } else {
            $foto = null;
        }

        $user = User::create([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'password' => bcrypt('bhamada'),
            'bagian' => $request->bagian,
            'foto' => $foto,
            'role' => 'user',
        ]);

        if (!$user) {
            alert()->error('Error', 'Gagal menambahkan Anggota!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Anggota');

        return redirect('admin/user');
    }

    public function edit($id)
    {
        $user = User::where([
            ['role', 'user'],
            ['id', $id]
        ])->first();

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required|unique:users,telp,' . $id . ',id',
            'bagian' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nama.required' => 'Nama Anggota tidak boleh kosong!',
            'telp.required' => 'No Telepon tidak boleh kosong!',
            'telp.unique' => 'No Telepon sudah digunakan!',
            'bagian.required' => 'Bagian harus dipilih!',
            'foto.image' => 'Foto harus berformat jpeg, jpg, png!',
            'foto.max' => 'Foto maksimal ukuran 2 MB',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Anggota!');
            return back()->withInput()->withErrors($validator);
        }

        $kode = date('YmdHis');

        if ($request->foto) {
            Storage::disk('local')->delete('public/uploads/' . $request->foto);
            $foto = 'user/' . $kode . '_' . random_int(10, 99) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto);
        } else {
            $foto = User::where('id', $id)->value('foto');
        }

        if ($request->is_cbt == 'on') {
            $is_cbt = true;
        } else {
            $is_cbt = false;
        }

        if ($is_cbt) {
            User::where('is_cbt', true)->update([
                'is_cbt' => false,
            ]);
        }

        $user = User::where([
            ['role', 'user'],
            ['id', $id]
        ])->update([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'foto' => $foto,
            'is_cbt' => $is_cbt
        ]);

        if (!$user) {
            alert()->error('Error', 'Gagal memperbarui Anggota!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Anggota');
        return redirect('admin/user');
    }

    public function destroy($id)
    {
        $user = User::where([
            ['role', 'user'],
            ['id', $id]
        ])->first();

        if (!$user) {
            alert()->error('Error', 'Gagal menghapus Anggota!');
            return back();
        }

        Storage::disk('local')->delete('public/uploads/' . $user->foto);
        $user->delete();

        alert()->success('Success', 'Berhasil menghapus Anggota');
        return back();
    }

    public function reset($id)
    {
        User::where('id', $id)->update([
            'password' => bcrypt('bhamada')
        ]);

        alert()->success('Success', 'Berhasil mereset Password');
        return back();
    }
}
