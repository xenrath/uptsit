<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\DetailHosting;
use App\Models\Hosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class HostingController extends Controller
{
    public function index()
    {
        $hostings = Hosting::where('user_id', auth()->user()->id)->get();

        return view('tamu.hosting.index', compact('hostings'));
    }

    public function create()
    {
        return view('tamu.hosting.create');
    }

    public function store(Request $request)
    {
        $validator_permohonan = Validator::make($request->all(), [
            'kategori' => 'required',
            'nama_instansi' => 'required',
        ], [
            'kategori.required'  => 'Kategori harus dipilih!',
            'nama_instansi.required' => 'Nama Instansi harus diisi!',
        ]);

        if ($validator_permohonan->fails()) {
            $error_permohonan = $validator_permohonan->errors()->all();
        } else {
            $error_permohonan = null;
        }

        $validator_kepala = Validator::make($request->all(), [
            'nama_kepala' => 'required',
            'nipy_kepala' => 'required',
            'jabatan_kepala' => 'required',
        ], [
            'nama_kepala.required' => 'Nama harus diisi!',
            'nipy_kepala.required'  => 'NIPY harus diisi!',
            'jabatan_kepala.required'  => 'Jabatan harus diisi!',
        ]);

        if ($validator_kepala->fails()) {
            $error_kepala = $validator_kepala->errors()->all();
        } else {
            $error_kepala = null;
        }

        $validator_admin_1 = Validator::make($request->all(), [
            'nama_admin_1' => 'required',
            'nipy_admin_1' => 'required',
            'jabatan_admin_1' => 'required',
            'email_admin_1' => 'required',
            'telp_admin_1' => 'required',
        ], [
            'nama_admin_1.required' => 'Nama harus diisi!',
            'nipy_admin_1.required'  => 'NIPY harus diisi!',
            'jabatan_admin_1.required'  => 'Jabatan harus diisi!',
            'email_admin_1.required'  => 'Email harus diisi!',
            'telp_admin_1.required'  => 'No. Telepon harus diisi!',
        ]);

        if ($validator_admin_1->fails()) {
            $error_admin_1 = $validator_admin_1->errors()->all();
        } else {
            $error_admin_1 = null;
        }

        $validator_admin_2 = Validator::make($request->all(), [
            'nama_admin_2' => 'required',
            'nipy_admin_2' => 'required',
            'jabatan_admin_2' => 'required',
            'email_admin_2' => 'required',
            'telp_admin_2' => 'required',
        ], [
            'nama_admin_2.required' => 'Nama harus diisi!',
            'nipy_admin_2.required'  => 'NIPY harus diisi!',
            'jabatan_admin_2.required'  => 'Jabatan harus diisi!',
            'email_admin_2.required'  => 'Email harus diisi!',
            'telp_admin_2.required'  => 'No. Telepon harus diisi!',
        ]);

        if ($validator_admin_2->fails()) {
            $error_admin_2 = $validator_admin_2->errors()->all();
        } else {
            $error_admin_2 = null;
        }

        $validator_detail = Validator::make($request->all(), [
            'deskripsi' => 'required',
            'sub_domain' => 'required',
            'ip_address' => 'required',
        ], [
            'deskripsi.required' => 'Deskripsi harus diisi!',
            'sub_domain.required'  => 'Sub Domain harus diisi!',
            'ip_address.required'  => 'IP Address harus diisi!',
        ]);

        if ($validator_detail->fails()) {
            $error_detail = $validator_detail->errors()->all();
        } else {
            $error_detail = null;
        }

        if ($error_permohonan || $error_kepala || $error_admin_1 || $error_admin_2 || $error_detail) {
            return back()->withInput()
                ->with('error_permohonan', $error_permohonan)
                ->with('error_kepala', $error_kepala)
                ->with('error_admin_1', $error_admin_1)
                ->with('error_admin_2', $error_admin_2)
                ->with('error_detail', $error_detail);
        }

        Hosting::create(array_merge($request->all(), [
            'user_id' => auth()->user()->id,
            'tanggal_awal' => Carbon::now()->format('Y-m-d'),
            'status' => 'menunggu'
        ]));

        alert()->success('Success', 'Berhasil membuat permohonan Web Hosting');

        return redirect('tamu/hosting');
    }

    public function show($id)
    {
        $hosting = Hosting::where([
            ['id', $id],
            ['user_id', auth()->user()->id]
        ])->first();

        if (!$hosting) {
            return view('error.404');
        }

        return view('tamu.hosting.show', compact('hosting'));
    }

    public function download($id)
    {
        $hosting = Hosting::where([
            ['id', $id],
            ['user_id', auth()->user()->id]
        ])->first();

        if (!$hosting) {
            return view('error.404');
        }

        // return $hosting->detail_hostings[0];

        $pdf = PDF::loadview('tamu.hosting.print', compact('hosting'));

        return $pdf->stream('surat_permohonan');

        // return $pdf->download('document.pdf');

        // return view('tamu.hosting.print', compact('hosting'));
    }
}
