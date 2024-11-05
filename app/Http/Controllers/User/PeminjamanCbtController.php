<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\User;
use App\Models\PeminjamanCbt;
use App\Models\Prodi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;

class PeminjamanCbtController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman_cbts = PeminjamanCbt::where('status', 'disetujui')
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
            )
            ->with('prodi:id,nama')
            ->orderBy('tanggal_awal')
            ->orderBy('jam_awal')
            ->get();
        $prodis = Prodi::select(
            'id',
            'nama'
        )->get();
        // 
        return view('user.peminjaman-cbt.index', compact('peminjaman_cbts', 'prodis'));
    }

    public function create()
    {
        return view('user.peminjaman-cbt.create');
    }

    public function store(Request $request)
    {
        $error = array();
        $validator_satu = Validator::make($request->all(), [
            'tanggal_awal' => 'required',
            'lama' => 'required',
        ], [
            'tanggal_awal.required' => 'Tanggal Pinjam harus diisi!',
            'lama.required' => 'Lama Peminjaman harus diisi!',
        ]);
        // 
        if ($validator_satu->fails()) {
            $error_satu = $validator_satu->errors()->all();
            foreach ($error_satu as $value) {
                array_push($error, $value);
            }
        }
        // 
        if (!is_null($request->jumlahs)) {
            foreach ($request->jumlahs as $key => $value) {
                if (is_null($value)) {
                    array_push($error, 'Jumlah ' . ucfirst($key) . ' harus diisi!');
                }
            }
        }
        // 
        $validator_tiga = Validator::make($request->all(), [
            'keterangan' => 'required',
            'pj' => 'required',
        ], [
            'keterangan.required' => 'Uraian Kegiatan harus diisi!',
            'pj.required' => 'Penanggung Jawab harus diisi!',
        ]);
        // 
        if ($validator_tiga->fails()) {
            $error_tiga = $validator_tiga->errors()->all();
            foreach ($error_tiga as $value) {
                array_push($error, $value);
            }
        }
        // 
        if ($error) {
            return back()->withInput()->with('error', $error);
        }
        // 
        $tanggal_akhir = Carbon::parse($request->tanggal_awal)->addDays($request->lama - 1)->format('Y-m-d');
        // 
        $cek = $this->cek_peminjaman(
            $request->tanggal_awal,
            $tanggal_akhir,
            '08:00',
            '16:00'
        );
        // 
        if (count($cek) > 0) {
            return back()->withInput()->with('cek', $cek);
        }
        // 
        $peminjaman_cbt = PeminjamanCbt::create([
            'kode' => Str::random(6),
            'keperluan' => 'lainnya',
            'nama' => 'Admin IT',
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jam_awal' => '08:00',
            'jam_akhir' => '16:00',
            'items' => $request->items,
            'jumlahs' => $request->jumlahs,
            'keterangan' => $request->keterangan,
            'pj' => $request->pj,
            'telp' => null,
            'status' => 'disetujui'
        ]);
        // 
        if (!$peminjaman_cbt) {
            alert()->error('Error', 'Gagal membuat Peminjaman!');
            return back();
        }
        // 
        alert()->success('Success', 'Berhasil membuat Peminjaman');
        return redirect('user/peminjaman-cbt');
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

        $cek = $this->cek_peminjaman_ubah(
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

    public function batalkan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pembatalan' => 'required',
        ], [
            'pembatalan.required' => 'Keterangan harus diisi!',
        ]);
        // 
        if ($validator->fails()) {
            alert()->error('Error', 'Gagal membatalkan Peminjaman!');
            return back()->withInput()->withErrors($validator->errors())->with('id', $id);
        }
        //
        $update = PeminjamanCbt::where('id', $id)->update([
            'pembatalan' => $request->pembatalan,
            'status' => 'batal',
        ]);
        // 
        if (!$update) {
            alert()->error('Error', 'Gagal membatalkan Peminjaman!');
            return back();
        }
        // 
        $message = "Peminjaman Laboratorium CBT"  . PHP_EOL;
        $message .= "----------------------------------"  . PHP_EOL;
        $message .= "Mohon maaf peminjaman laboratorium CBT Anda dibatalkan." . PHP_EOL;
        $message .= "Keterangan : " . $request->pembatalan . PHP_EOL;
        $message .= "----------------------------------"  . PHP_EOL;
        $message .= "Maaf atas ketidaknyamanannya 🙏";
        //
        $telp = PeminjamanCbt::where('id', $id)->value('telp');
        $this->kirim($telp, $message);
        // 
        alert()->success('Success', 'Berhasil membatalkan Peminjaman');
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
        $peminjaman_cbts = PeminjamanCbt::where(function ($query) {
            $query->where('status', '!=', 'menunggu');
            $query->where('tanggal_akhir', '<', Carbon::now()->format('Y-m-d'));
        })
            ->orWhere('status', 'batal')
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
                'pembatalan',
                'status',
            )
            ->with('prodi:id,nama')
            ->orderByDesc('tanggal_akhir')
            ->orderBy('jam_awal')
            ->paginate(10);
        // 
        return view('user.peminjaman-cbt.riwayat', compact('peminjaman_cbts'));
    }

    public function cek_peminjaman($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir)
    {
        $peminjaman_cbts = PeminjamanCbt::where(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
            $query->where('status', 'disetujui');
            $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
            $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
            });
        })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->where('jam_awal', '<', $jam_awal);
                    $query->where('jam_akhir', '>', $jam_akhir);
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('status', 'disetujui');
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

    public function cek_peminjaman_ubah($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir)
    {
        $peminjaman_cbts = PeminjamanCbt::where(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
            $query->where('id', '!=', $id);
            $query->where('status', 'disetujui');
            $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
            $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
            });
        })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_awal', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->where('jam_awal', '<', $jam_awal);
                    $query->where('jam_akhir', '>', $jam_akhir);
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_awal', array($jam_awal, Carbon::parse($jam_akhir)->subMinute()->format('H:i')));
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->where('status', 'disetujui');
                $query->whereBetween('tanggal_akhir', array($tanggal_awal, $tanggal_akhir));
                $query->where(function ($query) use ($jam_awal, $jam_akhir) {
                    $query->whereBetween('jam_akhir', array(Carbon::parse($jam_awal)->addMinute()->format('H:i'), $jam_akhir));
                });
            })
            ->orWhere(function ($query) use ($id, $tanggal_awal, $tanggal_akhir, $jam_awal, $jam_akhir) {
                $query->where('id', '!=', $id);
                $query->where('status', 'disetujui');
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

    public function kirim($telp, $message)
    {
        $data = [
            'target' => $telp,
            'message' => $message
        ];

        $curl = curl_init();
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: BUbqFXgpVtdH3EoMj@u7",
            )
        );

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = json_decode(curl_exec($curl));

        return $result;
    }

    public function hubungi($id)
    {
        $telp = PeminjamanCbt::where('id', $id)->value('telp');

        if (is_null($telp)) {
            alert()->error('Error', 'Gagal menemukan Nomor Telepon!');
            return back();
        }

        $agent = new Agent;
        $desktop = $agent->isDesktop();

        if ($desktop) {
            return redirect()->away('https://web.whatsapp.com/send?phone=' . $telp);
        } else {
            return redirect()->away('https://wa.me/' . $telp);
        }
    }
}
