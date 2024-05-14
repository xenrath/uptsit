<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanCbt;
use App\Models\Prodi;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanCbtController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal;
        if ($tanggal) {
            $peminjaman_cbts = PeminjamanCbt::where('tanggal_awal', '<=', $tanggal)
                ->where('tanggal_akhir', '>=', $tanggal)
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
                    'telp',
                )
                ->with('prodi:id,nama')
                ->orderBy('tanggal_awal')
                ->orderBy('jam_awal')
                ->get();
        } else {
            $peminjaman_cbts = PeminjamanCbt::where('tanggal_awal', '<=', Carbon::now()->format('Y-m-d'))
                ->where('tanggal_akhir', '>=', Carbon::now()->format('Y-m-d'))
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
                    'telp'
                )
                ->with('prodi:id,nama')
                ->orderBy('tanggal_awal')
                ->orderBy('jam_awal')
                ->get();
        }

        return view('peminjaman-cbt.index', compact('peminjaman_cbts'));
    }

    public function create()
    {
        SEOMeta::setTitle('Peminjaman CBT');

        return view('peminjaman-cbt.create');
    }

    public function store(Request $request)
    {
        if ($request->keperluan == 'pembelajaran') {
            return redirect('peminjaman-cbt/pembelajaran');
        } elseif ($request->keperluan == 'lainnya') {
            return redirect('peminjaman-cbt/lainnya');
        } else {
            return back()->with('error', 'Gagal menemukan Keperluan!');
        }
    }

    public function create_pembelajaran()
    {
        SEOMeta::setTitle('Peminjaman CBT');

        $prodis = Prodi::select(
            'id',
            'nama'
        )->get();

        return view('peminjaman-cbt.create_pembelajaran', compact('prodis'));
    }

    public function create_lainnya()
    {
        SEOMeta::setTitle('Peminjaman CBT');

        return view('peminjaman-cbt.create_lainnya');
    }

    public function store_pembelajaran(Request $request)
    {
        $error = array();

        $validator_satu = Validator::make($request->all(), [
            'nama' => 'required',
            'tanggal_awal' => 'required',
            'prodi_id' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
        ], [
            'nama.required' => 'Nama Mahasiswa harus diisi!',
            'prodi_id.required' => 'Prodi harus dipilih!',
            'tanggal_awal.required' => 'Tanggal Pinjam harus diisi!',
            'jam_awal.required' => 'Jam Mulai harus dipilih!',
            'jam_akhir.required' => 'Jam Akhir harus dipilih!',
        ]);

        if ($validator_satu->fails()) {
            $error_satu = $validator_satu->errors()->all();
            foreach ($error_satu as $value) {
                array_push($error, $value);
            }
        }

        if (!is_null($request->jumlahs)) {
            foreach ($request->jumlahs as $key => $value) {
                if (is_null($value)) {
                    array_push($error, 'Jumlah ' . ucfirst($key) . ' harus diisi!');
                }
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

        $cek = $this->cek_peminjaman(
            $request->tanggal_awal,
            $request->tanggal_awal,
            $request->jam_awal,
            $request->jam_akhir
        );

        if (count($cek) > 0) {
            return back()->withInput()->with('cek', $cek);
        }

        PeminjamanCbt::create([
            'keperluan' => 'pembelajaran',
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_awal,
            'jam_awal' => $request->jam_awal,
            'jam_akhir' => $request->jam_akhir,
            'items' => $request->items,
            'jumlahs' => $request->jumlahs,
            'keterangan' => $request->keterangan,
            'pj' => $request->pj,
            'status' => 'menunggu'
        ]);

        alert()->success('Success', 'Berhasil membuat Peminjaman');

        return redirect('peminjaman-cbt');
    }

    public function store_lainnya(Request $request)
    {
        $error = array();

        $validator_satu = Validator::make($request->all(), [
            'nama' => 'required',
            'tanggal_awal' => 'required',
            'lama' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
        ], [
            'nama.required' => 'Nama Lengkap harus diisi!',
            'tanggal_awal.required' => 'Tanggal Pinjam harus diisi!',
            'lama.required' => 'Lama Peminjaman harus diisi!',
            'jam_awal.required' => 'Jam Mulai harus dipilih!',
            'jam_akhir.required' => 'Jam Akhir harus dipilih!',
        ]);

        if ($validator_satu->fails()) {
            $error_satu = $validator_satu->errors()->all();
            foreach ($error_satu as $value) {
                array_push($error, $value);
            }
        }

        if (!is_null($request->jumlahs)) {
            foreach ($request->jumlahs as $key => $value) {
                if (is_null($value)) {
                    array_push($error, 'Jumlah ' . ucfirst($key) . ' harus diisi!');
                }
            }
        }

        $validator_tiga = Validator::make($request->all(), [
            'keterangan' => 'required',
            'pj' => 'required',
            'telp' => 'required',
        ], [
            'keterangan.required' => 'Uraian Kegiatan harus diisi!',
            'pj.required' => 'Penanggung Jawab harus diisi!',
            'telp.required' => 'Nomor Telepon harus diisi!',
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

        $tanggal_akhir = Carbon::parse($request->tanggal_awal)->addDays($request->lama - 1)->format('Y-m-d');

        $cek = $this->cek_peminjaman(
            $request->tanggal_awal,
            $tanggal_akhir,
            $request->jam_awal,
            $request->jam_akhir
        );

        if (count($cek) > 0) {
            return back()->withInput()->with('cek', $cek);
        }

        PeminjamanCbt::create([
            'keperluan' => 'lainnya',
            'nama' => $request->nama,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jam_awal' => $request->jam_awal,
            'jam_akhir' => $request->jam_akhir,
            'items' => $request->items,
            'jumlahs' => $request->jumlahs,
            'keterangan' => $request->keterangan,
            'pj' => $request->pj,
            'telp' => $request->telp,
            'status' => 'menunggu'
        ]);

        alert()->success('Success', 'Berhasil membuat Peminjaman');

        return redirect('peminjaman-cbt');
    }

    public function cek_peminjaman($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir)
    {
        $peminjaman_cbts = PeminjamanCbt::where(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
            $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
            $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
            });
        })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->where('jam_awal', '<', $jam_awal);
                    $query->where('jam_akhir', '>', $jam_akhir);
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
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
