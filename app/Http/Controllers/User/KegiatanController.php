<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::where('user_id', auth()->user()->id)
            ->select('id', 'tanggal', 'deskripsi')
            ->paginate(10);

        return view('user.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('user.kegiatan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'deskripsi' => 'required',
            'bukti' => 'required',
        ], [
            'tanggal.required' => 'Tanggal harus dipilih!',
            'deskripsi.required' => 'Deskripsi Kegiatan tidak boleh kosong!',
            'bukti.required' => 'Bukti Foto harus diisi!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal menambahkan Kegiatan!');
            return back()->withInput()->withErrors($validator);
        }

        foreach ($request->bukti as $bukti) {
            $nama_bukti = 'bukti/' . Carbon::parse($request->tanggal)->format('ymd') . '_' . random_int(000, 999) . '.' . $bukti->getClientOriginalExtension();
            $bukti->storeAs('public/uploads/', $nama_bukti);
            $data_bukti[] = $nama_bukti;
        }

        $kegiatan = Kegiatan::create([
            'user_id' => auth()->user()->id,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'buktis' => $data_bukti,
        ]);

        if (!$kegiatan) {
            alert()->error('Error', 'Gagal menambahkan Kegiatan!');
            return back()->withInput()->withErrors($validator);
        }

        alert()->success('Success', 'Berhasil menambahkan Kegiatan');

        return back();
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();

        return view('user.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'deskripsi' => 'required',
        ], [
            'tanggal.required' => 'Tanggal harus dipilih!',
            'deskripsi.required' => 'Deskripsi Kegiatan tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Gagal memperbarui Kegiatan!');
            return back()->withInput()->withErrors($validator);
        }

        if (!$request->old_bukti && !$request->bukti) {
            alert()->error('Error', 'Bukti Foto tidak boleh kosong!');
            return back()->withInput();
        }

        $data_bukti = $request->old_bukti ?? array();

        $diff_bukti = array_diff(Kegiatan::where('id', $id)->value('buktis'), $data_bukti);

        if ($diff_bukti) {
            foreach ($diff_bukti as $bukti) {
                Storage::disk('local')->delete('public/uploads/' . $bukti);
            }
        }

        if ($request->bukti) {
            foreach ($request->bukti as $bukti) {
                $nama_bukti = 'bukti/' . Carbon::parse($request->tanggal)->format('ymd') . '_' . random_int(000, 999) . '.' . $bukti->getClientOriginalExtension();
                $bukti->storeAs('public/uploads/', $nama_bukti);
                array_push($data_bukti, $nama_bukti);
            }
        }

        $kegiatan = Kegiatan::where('id', $id)->update([
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'buktis' => $data_bukti,
        ]);

        if (!$kegiatan) {
            alert()->error('Error', 'Gagal memperbarui Kegiatan!');
            return back()->withInput()->withErrors($validator);
        }

        alert()->success('Success', 'Berhasil memperbarui Kegiatan');

        return redirect('user/kegiatan');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();

        foreach ($kegiatan->buktis as $bukti) {
            Storage::disk('local')->delete('public/uploads/' . $bukti);
        }

        $kegiatan->delete();

        alert()->success('Success', 'Berhasil menghapus Kegiatan');
        return back();
    }
}
