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
            'deskripsi' => 'required',
        ], [
            'nama.required'  => 'Nama pengadu harus ditambahkan!',
            'unit.required' => 'Unit / bagian harus ditambahkan!',
            'deskripsi.required' => 'Deskripsi harus diisi!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Pengaduan::create($request->all());

        return back()->with('success', 'Berhasil membuat Pengaduan');
    }
}
