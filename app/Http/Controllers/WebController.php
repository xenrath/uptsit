<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pengaduan;
use App\Models\Tupoksi;
use App\Models\Unit;
use App\Models\Visimisi;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
    public function home()
    {
        SEOMeta::setTitle('Home');

        $unit = Unit::first();
        $visimisi = Visimisi::first();

        return view('home', compact('unit', 'visimisi'));
    }

    public function about()
    {
        SEOMeta::setTitle('About');

        $unit = Unit::first();
        $visimisi = Visimisi::first();
        $anggotas = Anggota::get();

        return view('about', compact('unit', 'visimisi', 'anggotas'));
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

        $unit = Unit::first();

        return view('bandwith', compact('unit'));
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

    public function kontak()
    {
        SEOMeta::setTitle('Kontak');

        $anggotas = Anggota::get();

        return view('kontak', compact('anggotas'));
    }

    public function hubungi($id)
    {
        $anggota = Anggota::where('id', $id)->first();

        if (true) {
            return redirect()->away('https://web.whatsapp.com/send?phone=+62' . $anggota->telp);
        } else {
            return redirect()->away('https://wa.me/+62' . $anggota->telp);
        }
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
