<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use App\Models\Spesifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::orderBy('kategori')
            ->orderBy('merek')
            ->orderBy('model')
            ->orderBy('tipe')
            ->orderBy('kapasitas')
            ->get();

        return view('user.sparepart.index', compact('spareparts'));
    }

    public function create()
    {
        $kategori = request()->kategori;
        if (!$kategori) {
            alert()->error('Error', 'Kategori harus dipilih!');
            return back();
        }
        $list_kategori = array(
            'motherboard',
            'prosesor',
            'ram',
            'storage',
            'psu',
            'heatsink',
            'monitor',
            'keyboard',
            'mouse'
        );
        $cek = in_array($kategori, $list_kategori);

        if ($cek) {
            return redirect('user/sparepart/' . $kategori);
        } else {
            return view('error.500');
        }
    }

    public function create_motherboard()
    {
        $motherboard_mereks = Spesifikasi::where([
            ['kategori', 'motherboard'],
            ['grup', 'merek']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $prosesor_models = Spesifikasi::where([
            ['kategori', 'prosesor'],
            ['grup', 'model']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $ram_tipes = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'tipe']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.create_motherboard', compact(
            'motherboard_mereks',
            'prosesor_models',
            'ram_tipes'
        ));
    }

    public function create_prosesor()
    {
        $prosesor_models = Spesifikasi::where([
            ['kategori', 'prosesor'],
            ['grup', 'model']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.create_prosesor', compact('prosesor_models'));
    }

    public function create_ram()
    {
        $ram_mereks = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'merek']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $ram_tipes = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'tipe']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $ram_kapasitases = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'kapasitas']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.create_ram', compact('ram_mereks', 'ram_tipes', 'ram_kapasitases'));
    }

    public function create_storage()
    {
        $storage_mereks = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'merek']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $storage_kapasitases = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'kapasitas']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.create_storage', compact('storage_mereks', 'storage_kapasitases'));
    }

    public function create_psu()
    {
        return view('user.sparepart.create_psu');
    }

    public function create_heatsink()
    {
        return view('user.sparepart.create_heatsink');
    }

    public function create_monitor()
    {
        return view('user.sparepart.create_monitor');
    }

    public function create_keyboard()
    {
        return view('user.sparepart.create_keyboard');
    }

    public function create_mouse()
    {
        return view('user.sparepart.create_mouse');
    }

    public function store_motherboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'model' => 'required',
            'tipe' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'model.required'  => 'Model Prosesor harus dipilih!',
            'tipe.required'  => 'Tipe RAM harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_merek = array();
        $validator_fails_merek = false;
        if ($request->merek == 'lainnya') {
            $validator_merek = Validator::make($request->all(), [
                'merek_nama' => 'required',
            ], [
                'merek_nama.required' => 'Nama Merek harus diisi!',
            ]);

            $error_merek = $validator_merek->errors();
            $validator_fails_merek = $validator_merek->fails();
        }

        $error_model = array();
        $validator_fails_model = false;
        if ($request->model == 'lainnya') {
            $validator_model = Validator::make($request->all(), [
                'model_nama' => 'required',
            ], [
                'model_nama.required' => 'Nama Model Prosesor harus diisi!',
            ]);

            $error_model = $validator_model->errors();
            $validator_fails_model = $validator_model->fails();
        }

        $error_tipe = array();
        $validator_fails_tipe = false;
        if ($request->tipe == 'lainnya') {
            $validator_tipe = Validator::make($request->all(), [
                'tipe_nama' => 'required',
            ], [
                'tipe_nama.required' => 'Nama Tipe RAM harus diisi!',
            ]);

            $error_tipe = $validator_tipe->errors();
            $validator_fails_tipe = $validator_tipe->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_merek || $validator_fails_model || $validator_fails_tipe || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_merek)
                    ->merge($error_model)
                    ->merge($error_tipe)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/motherboard_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/motherboard_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->merek == 'lainnya') {
            $merek = $request->merek_nama;
        } else {
            $merek = $request->merek;
        }

        if ($request->model == 'lainnya') {
            $model = $request->model_nama;
        } else {
            $model = $request->model;
        }

        if ($request->tipe == 'lainnya') {
            $tipe = $request->tipe_nama;
        } else {
            $tipe = $request->tipe;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'motherboard',
            'merek' => $merek,
            'model' => $model,
            'tipe' => $tipe,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'motherboard'],
                ['grup', 'merek'],
                ['keterangan', $merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'motherboard',
                    'grup' => 'merek',
                    'keterangan' => $merek,
                ]);
            }
        }

        if ($request->model == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'prosesor'],
                ['grup', 'model'],
                ['keterangan', $model]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'prosesor',
                    'grup' => 'model',
                    'keterangan' => $model,
                ]);
            }
        }

        if ($request->tipe == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'tipe'],
                ['keterangan', $tipe]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'tipe',
                    'keterangan' => $tipe,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_prosesor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'model.required'  => 'Model harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_model = array();
        $validator_fails_model = false;
        if ($request->model == 'lainnya') {
            $validator_model = Validator::make($request->all(), [
                'model_nama' => 'required',
            ], [
                'model_nama.required' => 'Nama Model harus diisi!',
            ]);

            $error_model = $validator_model->errors();
            $validator_fails_model = $validator_model->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_model || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_model)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/prosesor_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/prosesor_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->model == 'lainnya') {
            $model = $request->model_nama;
        } else {
            $model = $request->model;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'prosesor',
            'model' => $model,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->model == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'prosesor'],
                ['grup', 'model'],
                ['keterangan', $model]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'prosesor',
                    'grup' => 'model',
                    'keterangan' => $model,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_ram(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'tipe' => 'required',
            'kapasitas' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus dipilih!',
            'tipe.required'  => 'Tipe harus dipilih!',
            'kapasitas.required'  => 'Kapasitas harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_merek = array();
        $validator_fails_merek = false;
        if ($request->merek == 'lainnya') {
            $validator_merek = Validator::make($request->all(), [
                'merek_nama' => 'required',
            ], [
                'merek_nama.required' => 'Nama Merek harus diisi!',
            ]);

            $error_merek = $validator_merek->errors();
            $validator_fails_merek = $validator_merek->fails();
        }

        $error_tipe = array();
        $validator_fails_tipe = false;
        if ($request->tipe == 'lainnya') {
            $validator_tipe = Validator::make($request->all(), [
                'tipe_nama' => 'required',
            ], [
                'tipe_nama.required' => 'Nama Tipe harus diisi!',
            ]);

            $error_tipe = $validator_tipe->errors();
            $validator_fails_tipe = $validator_tipe->fails();
        }

        $error_kapasitas = array();
        $validator_fails_kapasitas = false;
        if ($request->kapasitas == 'lainnya') {
            $validator_kapasitas = Validator::make($request->all(), [
                'kapasitas_nama' => 'required|numeric',
            ], [
                'kapasitas_nama.required' => 'Nama Kapasitas harus diisi!',
                'kapasitas_nama.numeric' => ' Nama Kapasitas yang diisi salah!',
            ]);

            $error_kapasitas = $validator_kapasitas->errors();
            $validator_fails_kapasitas = $validator_kapasitas->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_merek || $validator_fails_tipe || $validator_fails_kapasitas || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_merek)
                    ->merge($error_tipe)
                    ->merge($error_kapasitas)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/ram_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/ram_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->merek == 'lainnya') {
            $merek = $request->merek_nama;
        } else {
            $merek = $request->merek;
        }

        if ($request->tipe == 'lainnya') {
            $tipe = $request->tipe_nama;
        } else {
            $tipe = $request->tipe;
        }

        if ($request->kapasitas == 'lainnya') {
            $kapasitas = $request->kapasitas_nama;
        } else {
            $kapasitas = $request->kapasitas;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'ram',
            'merek' => $merek,
            'tipe' => $tipe,
            'kapasitas' => $kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'merek'],
                ['keterangan', $merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'merek',
                    'keterangan' => $merek,
                ]);
            }
        }

        if ($request->tipe == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'tipe'],
                ['keterangan', $tipe]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'tipe',
                    'keterangan' => $tipe,
                ]);
            }
        }

        if ($request->kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'kapasitas'],
                ['keterangan', $kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'kapasitas',
                    'keterangan' => $kapasitas,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_storage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipe' => 'required',
            'merek' => 'required',
            'kapasitas' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'tipe.required'  => 'Tipe harus dipilih!',
            'merek.required'  => 'Merek harus dipilih!',
            'kapasitas.required'  => 'Kapasitas harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_merek = array();
        $validator_fails_merek = false;
        if ($request->merek == 'lainnya') {
            $validator_merek = Validator::make($request->all(), [
                'merek_nama' => 'required',
            ], [
                'merek_nama.required' => 'Nama Merek harus diisi!',
            ]);

            $error_merek = $validator_merek->errors();
            $validator_fails_merek = $validator_merek->fails();
        }

        $error_kapasitas = array();
        $validator_fails_kapasitas = false;
        if ($request->kapasitas == 'lainnya') {
            $validator_kapasitas = Validator::make($request->all(), [
                'kapasitas_nama' => 'required|numeric',
            ], [
                'kapasitas_nama.required' => 'Nama Kapasitas harus diisi!',
                'kapasitas_nama.numeric' => ' Nama Kapasitas yang diisi salah!',
            ]);

            $error_kapasitas = $validator_kapasitas->errors();
            $validator_fails_kapasitas = $validator_kapasitas->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_merek || $validator_fails_kapasitas || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_merek)
                    ->merge($error_kapasitas)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/storage_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/storage_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->merek == 'lainnya') {
            $merek = $request->merek_nama;
        } else {
            $merek = $request->merek;
        }

        if ($request->kapasitas == 'lainnya') {
            $kapasitas = $request->kapasitas_nama;
        } else {
            $kapasitas = $request->kapasitas;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'storage',
            'tipe' => $request->tipe,
            'merek' => $merek,
            'kapasitas' => $kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'merek'],
                ['keterangan', $merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'merek',
                    'keterangan' => $merek,
                ]);
            }
        }

        if ($request->kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'kapasitas'],
                ['keterangan', $kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'kapasitas',
                    'keterangan' => $kapasitas,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_psu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'kapasitas' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'kapasitas.required'  => 'Kapasitas harus diisi!',
            'kapasitas.numeric'  => 'Kapasitas yang dimasukan salah!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/psu_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/psu_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'psu',
            'merek' => $request->merek,
            'kapasitas' => $request->kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_heatsink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'model' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'model.required'  => 'Model harus diisi!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/heatsink_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/heatsink_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'heatsink',
            'merek' => $request->merek,
            'model' => $request->model,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_monitor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'kapasitas' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'kapasitas.required'  => 'Ukuran harus diisi!',
            'kapasitas.numeric'  => 'Ukuran yang dimasukan salah!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/monitor_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/monitor_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'monitor',
            'merek' => $request->merek,
            'kapasitas' => $request->kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_keyboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/keyboard_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/keyboard_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'keyboard',
            'merek' => $request->merek,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function store_mouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => 'required|image|mimes:jpg,png,jpeg',
                'foto' => 'required|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            $bukti_nama = 'sparepart/mouse_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->storeAs('public/uploads/', $bukti_nama);
            $foto_nama = 'sparepart/mouse_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->storeAs('public/uploads/', $foto_nama);
        } else {
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::create([
            'kategori' => 'mouse',
            'merek' => $request->merek,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menambahkan Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Sparepart');

        return redirect('user/sparepart');
    }

    public function show()
    {
        return view('error.500');
    }

    public function edit($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if (!$kategori) {
            return view('error.404');
        }
        $list_kategori = array(
            'motherboard',
            'prosesor',
            'ram',
            'storage',
            'psu',
            'heatsink',
            'monitor',
            'keyboard',
            'mouse'
        );
        $cek = in_array($kategori, $list_kategori);

        if ($cek) {
            return redirect('user/sparepart/' . $kategori . '/' . $id);
        } else {
            return view('error.500');
        }
    }

    public function edit_motherboard($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'motherboard') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'merek',
                'model',
                'tipe',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();
        $motherboard_mereks = Spesifikasi::where([
            ['kategori', 'motherboard'],
            ['grup', 'merek']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $prosesor_models = Spesifikasi::where([
            ['kategori', 'prosesor'],
            ['grup', 'model']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $ram_tipes = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'tipe']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.edit_motherboard', compact(
            'sparepart',
            'motherboard_mereks',
            'prosesor_models',
            'ram_tipes'
        ));
    }

    public function edit_prosesor($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'prosesor') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'model',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )->first();
        $prosesor_models = Spesifikasi::where([
            ['kategori', 'prosesor'],
            ['grup', 'model']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.edit_prosesor', compact('sparepart', 'prosesor_models'));
    }

    public function edit_ram($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'ram') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'merek',
                'tipe',
                'kapasitas',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();
        $ram_mereks = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'merek']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $ram_tipes = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'tipe']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $ram_kapasitases = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'kapasitas']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.edit_ram', compact('sparepart', 'ram_mereks', 'ram_tipes', 'ram_kapasitases'));
    }

    public function edit_storage($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'storage') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'tipe',
                'merek',
                'kapasitas',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();
        $storage_mereks = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'merek']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');
        $storage_kapasitases = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'kapasitas']
        ])
            ->select('keterangan')
            ->get()
            ->sortBy('keterangan');

        return view('user.sparepart.edit_storage', compact('sparepart', 'storage_mereks', 'storage_kapasitases'));
    }

    public function edit_psu($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'psu') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'merek',
                'kapasitas',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();

        return view('user.sparepart.edit_psu', compact('sparepart'));
    }

    public function edit_heatsink($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'heatsink') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'merek',
                'model',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();

        return view('user.sparepart.edit_heatsink', compact('sparepart'));
    }

    public function edit_monitor($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'monitor') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'merek',
                'kapasitas',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();

        return view('user.sparepart.edit_monitor', compact('sparepart'));
    }

    public function edit_keyboard($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'keyboard') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'merek',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();

        return view('user.sparepart.edit_keyboard', compact('sparepart'));
    }

    public function edit_mouse($id)
    {
        $kategori = Sparepart::where('id', $id)->value('kategori');
        if ($kategori != 'mouse') {
            return view('error.404');
        }

        $sparepart = Sparepart::where('id', $id)
            ->select(
                'id',
                'merek',
                'jumlah',
                'is_baru',
                'tanggal',
                'garansi',
                'bukti',
                'foto',
                'keterangan'
            )
            ->first();

        return view('user.sparepart.edit_mouse', compact('sparepart'));
    }

    public function update_motherboard(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'model' => 'required',
            'tipe' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'model.required'  => 'Model Prosesor harus dipilih!',
            'tipe.required'  => 'Tipe RAM harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_merek = array();
        $validator_fails_merek = false;
        if ($request->merek == 'lainnya') {
            $validator_merek = Validator::make($request->all(), [
                'merek_nama' => 'required',
            ], [
                'merek_nama.required' => 'Nama Merek harus diisi!',
            ]);

            $error_merek = $validator_merek->errors();
            $validator_fails_merek = $validator_merek->fails();
        }

        $error_model = array();
        $validator_fails_model = false;
        if ($request->model == 'lainnya') {
            $validator_model = Validator::make($request->all(), [
                'model_nama' => 'required',
            ], [
                'model_nama.required' => 'Nama Model Prosesor harus diisi!',
            ]);

            $error_model = $validator_model->errors();
            $validator_fails_model = $validator_model->fails();
        }

        $error_tipe = array();
        $validator_fails_tipe = false;
        if ($request->tipe == 'lainnya') {
            $validator_tipe = Validator::make($request->all(), [
                'tipe_nama' => 'required',
            ], [
                'tipe_nama.required' => 'Nama Tipe RAM harus diisi!',
            ]);

            $error_tipe = $validator_tipe->errors();
            $validator_fails_tipe = $validator_tipe->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_merek || $validator_fails_model || $validator_fails_tipe || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_merek)
                    ->merge($error_model)
                    ->merge($error_tipe)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/motherboard_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/motherboard_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->merek == 'lainnya') {
            $merek = $request->merek_nama;
        } else {
            $merek = $request->merek;
        }

        if ($request->model == 'lainnya') {
            $model = $request->model_nama;
        } else {
            $model = $request->model;
        }

        if ($request->tipe == 'lainnya') {
            $tipe = $request->tipe_nama;
        } else {
            $tipe = $request->tipe;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'merek' => $merek,
            'model' => $model,
            'tipe' => $tipe,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'motherboard'],
                ['grup', 'merek'],
                ['keterangan', $merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'motherboard',
                    'grup' => 'merek',
                    'keterangan' => $merek,
                ]);
            }
        }

        if ($request->model == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'prosesor'],
                ['grup', 'model'],
                ['keterangan', $model]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'prosesor',
                    'grup' => 'model',
                    'keterangan' => $model,
                ]);
            }
        }

        if ($request->tipe == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'tipe'],
                ['keterangan', $tipe]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'tipe',
                    'keterangan' => $tipe,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_prosesor(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'model.required'  => 'Model harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_model = array();
        $validator_fails_model = false;
        if ($request->model == 'lainnya') {
            $validator_model = Validator::make($request->all(), [
                'model_nama' => 'required',
            ], [
                'model_nama.required' => 'Nama Model harus diisi!',
            ]);

            $error_model = $validator_model->errors();
            $validator_fails_model = $validator_model->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_model || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_model)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/prosesor_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/prosesor_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->model == 'lainnya') {
            $model = $request->model_nama;
        } else {
            $model = $request->model;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'model' => $model,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->model == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'prosesor'],
                ['grup', 'model'],
                ['keterangan', $model]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'prosesor',
                    'grup' => 'model',
                    'keterangan' => $model,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_ram(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'tipe' => 'required',
            'kapasitas' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus dipilih!',
            'tipe.required'  => 'Tipe harus dipilih!',
            'kapasitas.required'  => 'Kapasitas harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_merek = array();
        $validator_fails_merek = false;
        if ($request->merek == 'lainnya') {
            $validator_merek = Validator::make($request->all(), [
                'merek_nama' => 'required',
            ], [
                'merek_nama.required' => 'Nama Merek harus diisi!',
            ]);

            $error_merek = $validator_merek->errors();
            $validator_fails_merek = $validator_merek->fails();
        }

        $error_tipe = array();
        $validator_fails_tipe = false;
        if ($request->tipe == 'lainnya') {
            $validator_tipe = Validator::make($request->all(), [
                'tipe_nama' => 'required',
            ], [
                'tipe_nama.required' => 'Nama Tipe harus diisi!',
            ]);

            $error_tipe = $validator_tipe->errors();
            $validator_fails_tipe = $validator_tipe->fails();
        }

        $error_kapasitas = array();
        $validator_fails_kapasitas = false;
        if ($request->kapasitas == 'lainnya') {
            $validator_kapasitas = Validator::make($request->all(), [
                'kapasitas_nama' => 'required|numeric',
            ], [
                'kapasitas_nama.required' => 'Nama Kapasitas harus diisi!',
                'kapasitas_nama.numeric' => ' Nama Kapasitas yang diisi salah!',
            ]);

            $error_kapasitas = $validator_kapasitas->errors();
            $validator_fails_kapasitas = $validator_kapasitas->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_merek || $validator_fails_tipe || $validator_fails_kapasitas || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_merek)
                    ->merge($error_tipe)
                    ->merge($error_kapasitas)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/ram_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/ram_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->merek == 'lainnya') {
            $merek = $request->merek_nama;
        } else {
            $merek = $request->merek;
        }

        if ($request->tipe == 'lainnya') {
            $tipe = $request->tipe_nama;
        } else {
            $tipe = $request->tipe;
        }

        if ($request->kapasitas == 'lainnya') {
            $kapasitas = $request->kapasitas_nama;
        } else {
            $kapasitas = $request->kapasitas;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'merek' => $merek,
            'tipe' => $tipe,
            'kapasitas' => $kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'merek'],
                ['keterangan', $merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'merek',
                    'keterangan' => $merek,
                ]);
            }
        }

        if ($request->tipe == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'tipe'],
                ['keterangan', $tipe]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'tipe',
                    'keterangan' => $tipe,
                ]);
            }
        }

        if ($request->kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'kapasitas'],
                ['keterangan', $kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'kapasitas',
                    'keterangan' => $kapasitas,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_storage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tipe' => 'required',
            'merek' => 'required',
            'kapasitas' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'tipe.required'  => 'Tipe harus dipilih!',
            'merek.required'  => 'Merek harus dipilih!',
            'kapasitas.required'  => 'Kapasitas harus dipilih!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_merek = array();
        $validator_fails_merek = false;
        if ($request->merek == 'lainnya') {
            $validator_merek = Validator::make($request->all(), [
                'merek_nama' => 'required',
            ], [
                'merek_nama.required' => 'Nama Merek harus diisi!',
            ]);

            $error_merek = $validator_merek->errors();
            $validator_fails_merek = $validator_merek->fails();
        }

        $error_kapasitas = array();
        $validator_fails_kapasitas = false;
        if ($request->kapasitas == 'lainnya') {
            $validator_kapasitas = Validator::make($request->all(), [
                'kapasitas_nama' => 'required|numeric',
            ], [
                'kapasitas_nama.required' => 'Nama Kapasitas harus diisi!',
                'kapasitas_nama.numeric' => ' Nama Kapasitas yang diisi salah!',
            ]);

            $error_kapasitas = $validator_kapasitas->errors();
            $validator_fails_kapasitas = $validator_kapasitas->fails();
        }

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_merek || $validator_fails_kapasitas || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()
                    ->merge($error_merek)
                    ->merge($error_kapasitas)
                    ->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/storage_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/storage_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->merek == 'lainnya') {
            $merek = $request->merek_nama;
        } else {
            $merek = $request->merek;
        }

        if ($request->kapasitas == 'lainnya') {
            $kapasitas = $request->kapasitas_nama;
        } else {
            $kapasitas = $request->kapasitas;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'tipe' => $request->tipe,
            'merek' => $merek,
            'kapasitas' => $kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'merek'],
                ['keterangan', $merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'merek',
                    'keterangan' => $merek,
                ]);
            }
        }

        if ($request->kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'kapasitas'],
                ['keterangan', $kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'kapasitas',
                    'keterangan' => $kapasitas,
                ]);
            }
        }

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_psu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'kapasitas' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'kapasitas.required'  => 'Kapasitas harus diisi!',
            'kapasitas.numeric'  => 'Kapasitas yang dimasukan salah!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/psu_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/psu_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'merek' => $request->merek,
            'kapasitas' => $request->kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_heatsink(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'model' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'model.required'  => 'Model harus diisi!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/heatsink_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/heatsink_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'merek' => $request->merek,
            'model' => $request->model,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_monitor(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'kapasitas' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'kapasitas.required'  => 'Ukuran harus diisi!',
            'kapasitas.numeric'  => 'Ukuran yang dimasukan salah!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/monitor_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/monitor_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'merek' => $request->merek,
            'kapasitas' => $request->kapasitas,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_keyboard(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/keyboard_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/keyboard_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'merek' => $request->merek,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function update_mouse(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'merek.required'  => 'Merek harus diisi!',
            'jumlah.required'  => 'Jumlah Barang harus diisi!',
            'jumlah.numeric'  => 'Jumlah Barang yang dimasukan salah!',
        ]);

        $error_baru = array();
        $validator_fails_baru = false;
        if ($request->is_baru) {
            if (Sparepart::where('id', $id)->value('is_baru')) {
                $bukti_foto = 'nullable';
            } else {
                $bukti_foto = 'required';
            }
            $validator_baru = Validator::make($request->all(), [
                'tanggal' => 'required',
                'garansi' => 'required|numeric',
                'bukti' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
                'foto' => $bukti_foto . '|image|mimes:jpg,png,jpeg',
            ], [
                'tanggal.required' => 'Tanggal Pembelian harus diisi!',
                'garansi.required' => 'Garansi harus diisi!',
                'garansi.numeric' => 'Garansi yang dimasukan salah!',
                'bukti.required' => 'Bukti Garansi harus ditambahkan!',
                'bukti.image' => 'Bukti Garansi yang ditambahkan salah!',
                'bukti.mimes' => 'Bukti Garansi harus berformat jpg/png/jpeg!',
                'foto.required' => 'Foto Barang harus ditambahkan!',
                'foto.image' => 'Foto Barang yang ditambahkan salah!',
                'foto.mimes' => 'Foto Barang harus berformat jpg/png/jpeg!',
            ]);

            $error_baru = $validator_baru->errors();
            $validator_fails_baru = $validator_baru->fails();
        }

        if ($validator->fails() || $validator_fails_baru) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back()->withInput()->withErrors(
                $validator->errors()->merge($error_baru)
            );
        }

        if ($request->is_baru) {
            if ($request->bukti) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
                $bukti_nama = 'sparepart/mouse_' . Carbon::now()->format('ymdhis') . '.' . $request->bukti->getClientOriginalExtension();
                $request->bukti->storeAs('public/uploads/', $bukti_nama);
            } else {
                $bukti_nama = Sparepart::where('id', $id)->value('bukti');
            }
            if ($request->foto) {
                Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
                $foto_nama = 'sparepart/mouse_' . Carbon::now()->format('ymdhis') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads/', $foto_nama);
            } else {
                $foto_nama = Sparepart::where('id', $id)->value('foto');
            }
        } else {
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('bukti'));
            Storage::disk('local')->delete('public/uploads/' . Sparepart::where('id', $id)->value('foto'));
            $bukti_nama = null;
            $foto_nama = null;
        }

        if ($request->is_baru) {
            $is_baru = true;
            $tanggal = $request->tanggal;
            $garansi = $request->garansi;
            $bukti = $bukti_nama;
            $foto = $foto_nama;
        } else {
            $is_baru = false;
            $tanggal = null;
            $garansi = null;
            $bukti = null;
            $foto = null;
        }

        $sparepart = Sparepart::where('id', $id)->update([
            'merek' => $request->merek,
            'jumlah' => $request->jumlah,
            'is_baru' => $is_baru,
            'tanggal' => $tanggal,
            'garansi' => $garansi,
            'bukti' => $bukti,
            'foto' => $foto,
            'keterangan' => $request->keterangan,
        ]);

        if (!$sparepart) {
            alert()->error('Error', 'Gagal memperbarui Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Sparepart');

        return redirect('user/sparepart');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::where('id', $id)->delete();

        if (!$sparepart) {
            alert()->error('Error', 'Gagal menghapus Sparepart!');
            return back();
        }

        alert()->success('Success', 'Berhasil menghapus Sparepart');

        return back();
    }
}
