<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::select('id', 'nama')->get();

        return view('admin.prodi.index', compact('prodis'));
    }

    public function create()
    {
        return view('admin.prodi.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Prodi tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error[0]);
        }

        Prodi::create([
            'nama' => $request->nama
        ]);

        alert()->success('Success', 'Berhasil menambahkan Prodi');

        return redirect('admin/prodi');
    }
}
