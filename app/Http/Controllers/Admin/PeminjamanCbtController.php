<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanCbt;
use App\Models\Prodi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanCbtController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman_cbts = PeminjamanCbt::where('status', 'menunggu')
            ->select(
                'id',
                'keperluan',
                'nama',
                'prodi_id',
                'tanggal_awal',
                'tanggal_akhir',
                'jam_awal',
                'jam_akhir',
                'items',
                'jumlahs',
                'keterangan',
                'pj',
            )
            ->with('prodi:id,nama')
            ->orderBy('tanggal_awal')
            ->orderBy('jam_awal')
            ->get();

        $prodis = Prodi::select(
            'id',
            'nama'
        )->get();

        return view('admin.peminjaman-cbt.index', compact('peminjaman_cbts', 'prodis'));
    }

    public function destroy($id)
    {
        PeminjamanCbt::where('id', $id)->delete();

        alert()->success('Success', 'Berhasil menghapus Peminjaman');

        return back();
    }

    public function ubah_waktu(Request $request, $id)
    {
        $keperluan = PeminjamanCbt::where('id', $id)->value('keperluan');

        if ($keperluan == 'pembelajaran') {
            $validator = Validator::make($request->all(), [
                'tanggal_awal' => 'required',
                'jam_awal' => 'required',
                'jam_akhir' => 'required',
            ], [
                'tanggal_awal.required' => 'Tanggal Pinjam harus diisi!',
                'jam_awal.required' => 'Jam Mulai harus dipilih!',
                'jam_akhir.required' => 'Jam Akhir harus dipilih!',
            ]);
        } elseif ($keperluan == 'lainnya') {
            $validator = Validator::make($request->all(), [
                'tanggal_awal' => 'required',
                'tanggal_akhir' => 'required',
                'jam_awal' => 'required',
                'jam_akhir' => 'required',
            ], [
                'tanggal_awal.required' => 'Tanggal Pinjam harus diisi!',
                'tanggal_akhir.required' => 'Tanggal Pinjam harus diisi!',
                'jam_awal.required' => 'Jam Mulai harus dipilih!',
                'jam_akhir.required' => 'Jam Akhir harus dipilih!',
            ]);
        }

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->with('error', $error);
        }

        if ($keperluan == 'pembelajaran') {
            $tanggal_akhir = $request->tanggal_awal;
        } elseif ($keperluan == 'lainnya') {
            $tanggal_akhir = $request->tanggal_akhir;
        }

        $cek = $this->cek_peminjaman(
            $id,
            $request->tanggal_awal,
            $tanggal_akhir,
            $request->jam_awal,
            $request->jam_akhir
        );

        if (count($cek) > 0) {
            return back()->withInput()->with('cek', $cek);
        }

        PeminjamanCbt::where('id', $id)->update([
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jam_awal' => $request->jam_awal,
            'jam_akhir' => $request->jam_akhir,
        ]);

        alert()->success('Success', 'Berhasil mengubah Waktu Peminjaman');

        return back();
    }

    public function selesaikan($id)
    {
        PeminjamanCbt::where('id', $id)->update([
            'status' => 'selesai'
        ]);

        alert()->success('Success', 'Berhasil menyelesaikan Peminjaman');

        return back();
    }

    public function riwayat()
    {
        $peminjaman_cbts = PeminjamanCbt::where('status', 'selesai')
            ->select(
                'id',
                'keperluan',
                'nama',
                'prodi_id',
                'tanggal_awal',
                'tanggal_akhir',
                'jam_awal',
                'jam_akhir',
                'items',
                'jumlahs',
                'keterangan',
                'pj',
            )
            ->with('prodi:id,nama')
            ->orderBy('tanggal_awal')
            ->orderBy('jam_awal')
            ->get();

        return view('admin.peminjaman-cbt.riwayat', compact('peminjaman_cbts'));
    }

    public function cek_peminjaman($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir)
    {
        $peminjaman_cbts = PeminjamanCbt::where(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
            $query->where('id', '!=', $id);
            $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
            $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
            });
        })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->where('jam_awal', '<', $jam_awal);
                    $query->where('jam_akhir', '>', $jam_akhir);
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->where('jam_awal', '<', $jam_awal);
                    $query->where('jam_akhir', '>', $jam_akhir);
                });
            })
            ->select(
                'keperluan',
                'nama',
                'prodi_id',
                'tanggal_awal',
                'tanggal_akhir',
                'jam_awal',
                'jam_akhir',
                'keterangan',
                'pj'
            )
            ->with('prodi:id,nama')
            ->orderBy('tanggal_awal')
            ->orderBy('jam_awal')
            ->get();

        return $peminjaman_cbts;
    }
}
