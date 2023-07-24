<?php

namespace App\Http\Controllers\Admin\Pengaduan;

use App\Http\Controllers\Controller;
use App\Models\Catatan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class MasukController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::where('status', '!=', 'selesai')->get();
        return view('admin.pengaduan.masuk.index', compact('pengaduans'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::where('id', $id)->first();
        $catatans = Catatan::where('pengaduan_id', $pengaduan->id)->orderBy('created_at', 'desc')->get();

        return view('admin.pengaduan.masuk.show', compact('pengaduan', 'catatans'));
    }

    public function hubungi($id)
    {
        $pengaduan = Pengaduan::where('id', $id)->first();

        $agent = new Agent;
        $desktop = $agent->isDesktop();

        if ($desktop) {
            return redirect()->away('https://web.whatsapp.com/send?phone=' . $pengaduan->telp);
        } else {
            return redirect()->away('https://wa.me/' . $pengaduan->telp);
        }
    }

    public function konfirmasi_proses($id)
    {
        Pengaduan::where('id', $id)->update([
            'status' => 'proses'
        ]);

        Catatan::create([
            'pengaduan_id' => $id,
            'update' => 'proses',
        ]);

        return back()->with('success', 'Berhasil mengkonfirmasi Pengaduan');
    }

    public function konfirmasi_selesai($id)
    {
        Pengaduan::where('id', $id)->update([
            'status' => 'selesai'
        ]);

        Catatan::create([
            'pengaduan_id' => $id,
            'update' => 'selesai',
        ]);

        return redirect('admin/pengaduan-masuk')->with('success', 'Berhasil menyelesaikan Pengaduan');
    }

    public function catatan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'isi' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'isi.required' => 'Isi catatan tidak boleh kosong!',
            'gambar.image' => 'Gambar harus ditambahkan!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $gambar = array();
        if ($request->has('gambar')) {
            foreach ($request->file('gambar') as $g) {
                $nama = str_replace(' ', '', $g->getClientOriginalName());
                $namagambar = 'catatan/' . date('mYdHs') . random_int(1, 10) . '_' . $nama;
                $g->storeAs('public/uploads', $namagambar);
                $gambar[] = $namagambar;
            }
        }

        Catatan::create([
            'pengaduan_id' => $id,
            'isi' => $request->isi,
            'gambar' => $gambar
        ]);

        return back()->with('success', 'Berhasil menambahkan Catatan');
    }
}
