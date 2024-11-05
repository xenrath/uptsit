<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BagianController extends Controller
{
    public function index()
    {
        $bagians = Bagian::select('id', 'unit_id', 'sebagai')->with('unit:id,nama')->paginate(10);
        $units = Unit::select('id', 'nama')->get();

        return view('admin.bagian.index', compact('bagians', 'units'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required'  => 'Nama Unit harus diisi!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Unit!');
            return back()->withInput()->withErrors($validator);
        }

        $unit = Unit::create([
            'nama' => $request->nama
        ]);

        if (!$unit) {
            alert()->error('Error', 'Gagal menambahkan Unit!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Unit');

        return back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required'  => 'Nama Unit harus diisi!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Unit!');
            return back()->withInput()->with('id', $id)->withErrors($validator);
        }

        $unit = Unit::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        if (!$unit) {
            alert()->error('Error', 'Gagal memperbarui Unit!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Unit');

        return back();
    }

    public function destroy($id)
    {
        $unit = Unit::where('id', $id)->first();
        $unit->delete();

        alert()->success('Success', 'Berhasil menghapus Unit');

        return back();
    }
}
