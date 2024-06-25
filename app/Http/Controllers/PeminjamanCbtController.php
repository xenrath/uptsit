<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\PeminjamanCbt;
use App\Models\Prodi;
use Artesaos\SEOTools\Facades\SEOMeta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PeminjamanCbtController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal;
        if ($tanggal) {
            $peminjaman_cbts = PeminjamanCbt::where('status', '!=', 'menunggu')
                ->where('tanggal_awal', '<=', $tanggal)
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
            $peminjaman_cbts = PeminjamanCbt::where('status', '!=', 'menunggu')
                ->where('tanggal_awal', '<=', Carbon::now()->format('Y-m-d'))
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
            'telp' => 'required',
        ], [
            'keterangan.required' => 'Uraian Kegiatan harus diisi!',
            'pj.required' => 'Penanggung Jawab harus diisi!',
            'telp.required' => 'Nomor Peminjam harus diisi!',
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

        $peminjaman_cbt = PeminjamanCbt::create([
            'kode' => Str::random(6),
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
            'telp' => $request->telp,
            'status' => 'menunggu'
        ]);

        $message_konfirmasi = "Peminjaman Laboratorium CBT"  . PHP_EOL;
        $message_konfirmasi .= "----------------------------------"  . PHP_EOL;
        $message_konfirmasi .= "Link Konfirmasi Peminjaman untuk Penanggung Jawab" . PHP_EOL;
        $message_konfirmasi .= url('peminjaman-cbt/' . $peminjaman_cbt->kode) . PHP_EOL;
        $message_konfirmasi .= "----------------------------------"  . PHP_EOL;
        $message_konfirmasi .= "_kirim link ini ke penanggung jawab_";

        $this->kirim($peminjaman_cbt->telp, $message_konfirmasi);

        alert()->success('Success', 'Berhasil membuat Peminjaman');

        return redirect('peminjaman-cbt/create');
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

        $peminjaman_cbt = PeminjamanCbt::create([
            'kode' => Str::random(6),
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

        $message_konfirmasi = "Peminjaman Laboratorium CBT"  . PHP_EOL;
        $message_konfirmasi .= "----------------------------------"  . PHP_EOL;
        $message_konfirmasi .= "Link Konfirmasi Peminjaman untuk Penanggung Jawab" . PHP_EOL;
        $message_konfirmasi .= url('peminjaman-cbt/' . $peminjaman_cbt->kode) . PHP_EOL;
        $message_konfirmasi .= "----------------------------------"  . PHP_EOL;
        $message_konfirmasi .= "_kirim link ini ke penanggung jawab_";

        $this->kirim($peminjaman_cbt->telp, $message_konfirmasi);

        alert()->success('Success', 'Berhasil membuat Peminjaman');

        return redirect('peminjaman-cbt/create');
    }

    // Konfirmasi Peminjaman
    public function show($kode)
    {
        $peminjaman_cbt = PeminjamanCbt::where('kode', $kode)
            ->select(
                'kode',
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
                'status'
            )
            ->first();

        return view('peminjaman-cbt.konfirmasi', compact('peminjaman_cbt'));
    }

    // Proses Konfirmasi Peminjaman
    public function update(Request $request, $kode)
    {
        $ttd = $request->ttd;
        if (is_null($ttd)) {
            alert()->error('Error!', 'Tanda Tangan belum dilakukan!');
            return back();
        }

        $peminjaman_cbt = PeminjamanCbt::where('kode', $kode)->first();

        $cek = $this->cek_peminjaman(
            $peminjaman_cbt->tanggal_awal,
            $peminjaman_cbt->tanggal_awal,
            $peminjaman_cbt->jam_awal,
            $peminjaman_cbt->jam_akhir
        );

        if (count($cek) > 0) {
            return back()->withInput()->with('cek', $cek);
        }

        if ($peminjaman_cbt->status == 'disetujui') {
            alert()->error('Error!', 'Peminjaman sudah dikonfirmasi!');
            return back();
        }

        $ttd = str_replace('data:image/png;base64,', '', $ttd);
        $ttd = str_replace(' ', '+', $ttd);
        $namattd = 'ttd/' . $kode . '.' . 'png';
        File::put(public_path('storage/uploads') . '/' . $namattd, base64_decode($ttd));

        PeminjamanCbt::where('kode', $kode)->update([
            'ttd' => $namattd,
            'status' => 'disetujui'
        ]);

        if ($peminjaman_cbt->tanggal_awal == $peminjaman_cbt->tanggal_akhir) {
            $tanggal = Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F');
        } else {
            $tanggal = Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') . "-" . Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F');
        }

        $message = "Peminjaman Laboratorium CBT"  . PHP_EOL;
        $message .= "----------------------------------"  . PHP_EOL;
        $message .= "Nama Peminjam : " . $peminjaman_cbt->nama . PHP_EOL;
        $message .= "Tanggal : " . $tanggal . PHP_EOL;
        $message .= "Jam : " . $peminjaman_cbt->jam_awal . "-" . $peminjaman_cbt->jam_akhir  . PHP_EOL;
        $message .= "Penanggung Jawab : " . $peminjaman_cbt->pj . PHP_EOL;
        $message .= "----------------------------------"  . PHP_EOL;
        $message .= "Bukti Peminjaman Laboratorium CBT" . PHP_EOL;
        $message .= url('peminjaman-cbt/bukti/' . $peminjaman_cbt->kode);

        $telp = Anggota::where('is_cbt', true)->value('telp');

        $this->kirim($peminjaman_cbt->telp, $message);

        if ($telp) {
            $this->kirim($telp, $message);
        } else {
            $this->kirim('085328481969', $message);
        }

        alert()->success('Success', 'Berhasil mengkonfirmasi Peminjaman');
        return back();
    }

    public function bukti($kode)
    {
        $status = PeminjamanCbt::where('kode', $kode)->value('status');

        if ($status == 'menunggu') {
            alert()->error('Error!', 'Bukti peminjaman belum dikonfirmasi!');
            return redirect('peminjaman-cbt/' . $kode);
        }

        $peminjaman_cbt = PeminjamanCbt::where('kode', $kode)->first();
        $qr_pj = QrCode::size(60)->generate($peminjaman_cbt->pj);

        $pdf = Pdf::loadview('peminjaman-cbt.bukti', compact('peminjaman_cbt', 'qr_pj'));

        return $pdf->stream('Bukti Peminjaman (' . $peminjaman_cbt->kode . ')');
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
}
