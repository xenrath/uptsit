<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Identitas;
use App\Models\Jam;
use App\Models\PeminjamanCbt;
use App\Models\Pengaduan;
use App\Models\Prodi;
use App\Models\Tupoksi;
use App\Models\Unit;
use App\Models\User;
use App\Models\Visimisi;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class WebController extends Controller
{
    public function home()
    {
        SEOMeta::setTitle('Home');

        $identitas = Identitas::first();

        return view('home', compact('identitas'));
    }

    public function about()
    {
        SEOMeta::setTitle('About');

        $identitas = Identitas::first();

        $users = User::where('role', 'user')
            ->select('nama', 'telp', 'bagian', 'foto')
            ->get();

        return view('about', compact('identitas', 'users'));
    }

    public function tupoksi()
    {
        SEOMeta::setTitle('Tupoksi');

        $tupoksis = Tupoksi::get();

        return view('tupoksi', compact('tupoksis'));
    }

    public function bandwith()
    {
        SEOMeta::setTitle('Bandwith');

        $identitas = Identitas::first();

        return view('bandwith', compact('identitas'));
    }

    public function sistem()
    {
        SEOMeta::setTitle('Sistem');

        $unit = Unit::first();

        return view('sistem', compact('unit'));
    }

    public function sop()
    {
        SEOMeta::setTitle('SOP');

        $unit = Unit::first();

        return view('sop', compact('unit'));
    }

    public function kuesioner()
    {
        SEOMeta::setTitle('Kuesioner');

        $unit = Unit::first();

        return view('kuesioner', compact('unit'));
    }

    public function kontak()
    {
        SEOMeta::setTitle('Kontak');

        $user = User::where('role', 'admin')->select('telp', 'nama')->first();

        return view('kontak', compact('user'));
    }

    public function hubungi($telp)
    {
        $agent = new Agent;
        $desktop = $agent->isDesktop();

        if ($desktop) {
            return redirect()->away('https://web.whatsapp.com/send?phone=+62' . $telp);
        } else {
            return redirect()->away('https://wa.me/+62' . $telp);
        }
    }

    public function peminjaman_cbt()
    {
    }

    public function peminjaman_cbt_store(Request $request)
    {
        $error = array();

        $validator_satu = Validator::make($request->all(), [
            'keperluan' => 'required',
            'nama' => 'required',
            'prodi_id' => 'required',
            'jam_id' => 'required',
            'tanggal' => 'required'
        ], [
            'keperluan.required' => 'Keperluan harus dipilih!',
            'nama.required' => 'Nama Mahasiswa harus diisi!',
            'prodi_id.required' => 'Prodi harus dipilih!',
            'jam_id.required' => 'Jam Pinjam harus dipilih!',
            'tanggal.required' => 'Tanggal Pinjam harus diisi!'
        ]);

        if ($validator_satu->fails()) {
            $error_satu = $validator_satu->errors()->all();
            foreach ($error_satu as $value) {
                array_push($error, $value);
            }
        }

        if (!is_null($request->items)) {
            $validator_dua = Validator::make($request->all(), [
                'jumlah' => 'required',
            ], [
                'jumlah.required' => 'Jumlah Item harus dipilih!',
            ]);

            if ($validator_dua->fails()) {
                $error_dua = $validator_dua->errors()->all();
                array_push($error, $error_dua[0]);
            }
        }

        $validator_tiga = Validator::make($request->all(), [
            'keterangan' => 'required',
            'pj' => 'required',
        ], [
            'keterangan.required' => 'Uraian Kegiatan harus diisi!',
            'pj.required' => 'Penanggung Jawab harus diisi!',
        ]);

        if ($validator_tiga->fails()) {
            $error_tiga = $validator_tiga->errors()->all();
            foreach ($error_tiga as $value) {
                array_push($error, $value);
            }
        }

        if ($error) {
            return back()->withInput()->with('error', $error);
        }

        PeminjamanCbt::create([
            'keperluan' => $request->keperluan,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
            'jam_id' => $request->jam_id,
            'tanggal' => $request->tanggal,
            'items' => $request->items,
            'keterangan' => $request->keterangan,
            'pj' => $request->pj,
        ]);

        alert()->success('Success', 'Berhasil membuat Peminjaman');

        return back();
    }

    public function pengaduan()
    {
        SEOMeta::setTitle('Pengaduan');
        return view('pengaduan');
    }

    public function pengaduan_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'unit' => 'required',
            'telp' => 'required',
            'jenis' => 'required',
            'deskripsi' => 'required',
        ], [
            'nama.required'  => 'Nama pengadu harus ditambahkan!',
            'unit.required' => 'Unit / bagian harus ditambahkan!',
            'telp.required' => 'Nomor telepon harus ditambahkan!',
            'jenis.required' => 'Jenis aduan harus dipilih!',
            'deskripsi.required' => 'Deskripsi harus diisi!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $is_nol = substr($request->telp, 0, 1);

        if ($is_nol == '0') {
            $telp = "+62" . ltrim($request->telp, '0');
        } else {
            $telp = $request->telp;
        }

        Pengaduan::create(array_merge($request->all(), [
            'telp' => $telp
        ]));

        return back()->with('success', 'Berhasil membuat Pengaduan');
    }
}
