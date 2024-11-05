<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Perangkat;
use App\Models\Perbaikan;
use App\Models\Spesifikasi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PerangkatController extends Controller
{
    public function index()
    {
        $perangkats = Perangkat::select(
            'id',
            'karyawan_id',
            'unit_id',
            'jenis',
            'merek',
            'model',
            'no_seri',
            'ram_tipe',
            'ram_kapasitas',
            'ram_merek',
            'is_ram_tambahan',
            'ram_tambahan_kapasitas',
            'ram_tambahan_merek',
            'storage_tipe',
            'storage_kapasitas',
            'storage_merek',
            'is_storage_tambahan',
            'storage_tambahan_tipe',
            'storage_tambahan_kapasitas',
            'storage_tambahan_merek',
            'psu_kapasitas',
            'psu_merek',
            'heatsink_model',
            'heatsink_merek',
            'monitor_ukuran',
            'monitor_merek',
            'keyboard_merek',
            'mouse_merek',
            'keterangan',
        )
            ->with('karyawan:id,nama')
            ->with('unit:id,nama')
            ->get();

        return view('admin.perangkat.index', compact('perangkats'));
    }

    public function create()
    {
        $karyawans = Karyawan::select('id', 'nama', 'telp', 'bagian_id')
            ->with('bagian', function ($query) {
                $query->select('id', 'unit_id', 'sebagai')->with('unit:id,nama');
            })
            ->limit(10)
            ->orderBy('nama')
            ->get();
        $units = Unit::select('id', 'nama')->get();
        $mereks = Spesifikasi::where([
            ['kategori', 'motherboard'],
            ['grup', 'merek']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $models = Spesifikasi::where([
            ['kategori', 'prosesor'],
            ['grup', 'model']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $ram_tipes = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'tipe']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $ram_kapasitases = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'kapasitas']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $ram_mereks = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'merek']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $storage_kapasitases = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'kapasitas']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $storage_mereks = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'merek']
        ])->select('keterangan')->get()->sortBy('keterangan');

        return view('admin.perangkat.create', compact(
            'karyawans',
            'units',
            'mereks',
            'models',
            'ram_tipes',
            'ram_kapasitases',
            'ram_mereks',
            'storage_kapasitases',
            'storage_mereks',
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'jenis' => 'required',
            'merek' => 'required',
            'model' => 'required',
            'no_seri' => 'required|unique:perangkats,no_seri',
            'ram_tipe' => 'required',
            'ram_kapasitas' => 'required',
            'ram_merek' => 'required',
            'storage_tipe' => 'required',
            'storage_kapasitas' => 'required',
            'storage_merek' => 'required',
        ], [
            'unit_id.required' => 'Unit / Bagian harus dipilih!',
            'jenis.required' => 'Jenis Barang harus dipilih!',
            'merek.required' => 'Merek harus dipilih!',
            'model.required' => 'Model harus dipilih!',
            'no_seri.required' => 'No Seri harus diisi!',
            'no_seri.unique' => 'No Seri sudah digunakan!',
            'ram_tipe.required' => 'Tipe RAM harus dipilih!',
            'ram_kapasitas.required' => 'Kapasitas RAM harus diisi!',
            'ram_merek.required' => 'Merek RAM harus dipilih',
            'storage_tipe.required' => 'Tipe Storage harus dipilih!',
            'storage_kapasitas.required' => 'Kapasitas Storage harus diisi!',
            'storage_merek.required' => 'Merek Storage harus dipilih!',
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
                'model_nama.required' => 'Nama Model harus diisi!',
            ]);

            $error_model = $validator_model->errors();
            $validator_fails_model = $validator_model->fails();
        }

        $error_ram_tipe = array();
        $validator_fails_ram_tipe = false;
        if ($request->ram_tipe == 'lainnya') {
            $validator_ram_tipe = Validator::make($request->all(), [
                'ram_tipe_nama' => 'required',
            ], [
                'ram_tipe_nama.required' => 'Tipe RAM harus diisi!',
            ]);

            $error_ram_tipe = $validator_ram_tipe->errors();
            $validator_fails_ram_tipe = $validator_ram_tipe->fails();
        }

        $error_ram_kapasitas = array();
        $validator_fails_ram_kapasitas = false;
        if ($request->ram_kapasitas == 'lainnya') {
            $validator_ram_kapasitas = Validator::make($request->all(), [
                'ram_kapasitas_nama' => 'required',
            ], [
                'ram_kapasitas_nama.required' => 'Kapasitas RAM harus diisi!',
            ]);

            $error_ram_kapasitas = $validator_ram_kapasitas->errors();
            $validator_fails_ram_kapasitas = $validator_ram_kapasitas->fails();
        }

        $error_ram_merek = array();
        $validator_fails_ram_merek = false;
        if ($request->ram_merek == 'lainnya') {
            $validator_ram_merek = Validator::make($request->all(), [
                'ram_merek_nama' => 'required',
            ], [
                'ram_merek_nama.required' => 'Merek RAM harus diisi!',
            ]);

            $error_ram_merek = $validator_ram_merek->errors();
            $validator_fails_ram_merek = $validator_ram_merek->fails();
        }

        $error_ram_tambahan_kapasitas = array();
        $validator_fails_ram_tambahan_kapasitas = false;
        if ($request->is_ram_tambahan) {
            if ($request->ram_tambahan_kapasitas == 'lainnya') {
                $validator_ram_tambahan_kapasitas = Validator::make($request->all(), [
                    'ram_tambahan_kapasitas_nama' => 'required',
                ], [
                    'ram_tambahan_kapasitas_nama.required' => 'Kapasitas RAM harus diisi!',
                ]);

                $error_ram_tambahan_kapasitas = $validator_ram_tambahan_kapasitas->errors();
                $validator_fails_ram_tambahan_kapasitas = $validator_ram_tambahan_kapasitas->fails();
            }
        }

        $error_ram_tambahan_merek = array();
        $validator_fails_ram_tambahan_merek = false;
        if ($request->is_ram_tambahan) {
            if ($request->ram_tambahan_merek == 'lainnya') {
                $validator_ram_tambahan_merek = Validator::make($request->all(), [
                    'ram_tambahan_merek_nama' => 'required',
                ], [
                    'ram_tambahan_merek_nama.required' => 'Merek RAM harus diisi!',
                ]);

                $error_ram_tambahan_merek = $validator_ram_tambahan_merek->errors();
                $validator_fails_ram_tambahan_merek = $validator_ram_tambahan_merek->fails();
            }
        }

        $error_storage_kapasitas = array();
        $validator_fails_storage_kapasitas = false;
        if ($request->storage_kapasitas == 'lainnya') {
            $validator_storage_kapasitas = Validator::make($request->all(), [
                'storage_kapasitas_nama' => 'required',
            ], [
                'storage_kapasitas_nama.required' => 'Kapasitas Storage harus diisi!',
            ]);

            $error_storage_kapasitas = $validator_storage_kapasitas->errors();
            $validator_fails_storage_kapasitas = $validator_storage_kapasitas->fails();
        }

        $error_storage_merek = array();
        $validator_fails_storage_merek = false;
        if ($request->storage_merek == 'lainnya') {
            $validator_storage_merek = Validator::make($request->all(), [
                'storage_merek_nama' => 'required',
            ], [
                'storage_merek_nama.required' => 'Merek Storage harus diisi!',
            ]);

            $error_storage_merek = $validator_storage_merek->errors();
            $validator_fails_storage_merek = $validator_storage_merek->fails();
        }

        $error_storage_tambahan_kapasitas = array();
        $validator_fails_storage_tambahan_kapasitas = false;
        if ($request->is_storage_tambahan) {
            if ($request->storage_tambahan_kapasitas == 'lainnya') {
                $validator_storage_tambahan_kapasitas = Validator::make($request->all(), [
                    'storage_tambahan_kapasitas_nama' => 'required',
                ], [
                    'storage_tambahan_kapasitas_nama.required' => 'Kapasitas Storage harus diisi!',
                ]);

                $error_storage_tambahan_kapasitas = $validator_storage_tambahan_kapasitas->errors();
                $validator_fails_storage_tambahan_kapasitas = $validator_storage_tambahan_kapasitas->fails();
            }
        }

        $error_storage_tambahan_merek = array();
        $validator_fails_storage_tambahan_merek = false;
        if ($request->is_storage_tambahan) {
            if ($request->storage_tambahan_merek == 'lainnya') {
                $validator_storage_tambahan_merek = Validator::make($request->all(), [
                    'storage_tambahan_merek_nama' => 'required',
                ], [
                    'storage_tambahan_merek_nama.required' => 'Merek Storage harus diisi!',
                ]);

                $error_storage_tambahan_merek = $validator_storage_tambahan_merek->errors();
                $validator_fails_storage_tambahan_merek = $validator_storage_tambahan_merek->fails();
            }
        }

        $error_jenis_pc = array();
        $validator_fails_jenis_pc = false;
        if ($request->jenis == 'pc') {
            $validator_jenis_pc = Validator::make($request->all(), [
                'psu_kapasitas' => 'required',
                'psu_merek' => 'required',
                'heatsink_merek' => 'required',
                'heatsink_model' => 'required',
                'monitor_ukuran' => 'required',
                'monitor_merek' => 'required',
                'keyboard_merek' => 'required',
                'mouse_merek' => 'required',
            ], [
                'psu_kapasitas.required' => 'Kapasitas PSU harus diisi!',
                'psu_merek.required' => 'Merek PSU harus diisi!',
                'heatsink_merek.required' => 'Merek Heatsink harus diisi',
                'heatsink_model.required' => 'Model Heatsink harus diisi',
                'monitor_ukuran.required' => 'Ukuran Monitor harus diisi',
                'monitor_merek.required' => 'Merek Monitor harus diisi',
                'keyboard_merek.required' => 'Merek Keyboard harus diisi',
                'mouse_merek.required' => 'Merek Mouse harus diisi',
            ]);

            $error_jenis_pc = $validator_jenis_pc->errors();
            $validator_fails_jenis_pc = $validator_jenis_pc->fails();
        }

        if (
            $validator->fails() ||
            $validator_fails_merek ||
            $validator_fails_model ||
            $validator_fails_ram_tipe ||
            $validator_fails_ram_kapasitas ||
            $validator_fails_ram_merek ||
            $validator_fails_ram_tambahan_kapasitas ||
            $validator_fails_ram_tambahan_merek ||
            $validator_fails_storage_kapasitas ||
            $validator_fails_storage_merek ||
            $validator_fails_storage_tambahan_kapasitas ||
            $validator_fails_storage_tambahan_merek ||
            $validator_fails_jenis_pc
        ) {
            alert()->error('Error', 'Gagal menambahkan Perangkat!');
            return back()->withInput()
                ->withErrors(
                    $validator->errors()
                        ->merge($error_merek)
                        ->merge($error_model)
                        ->merge($error_ram_tipe)
                        ->merge($error_ram_kapasitas)
                        ->merge($error_ram_merek)
                        ->merge($error_ram_tambahan_kapasitas)
                        ->merge($error_ram_tambahan_merek)
                        ->merge($error_storage_kapasitas)
                        ->merge($error_storage_merek)
                        ->merge($error_storage_tambahan_kapasitas)
                        ->merge($error_storage_tambahan_merek)
                        ->merge($error_jenis_pc)
                );
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

        if ($request->ram_tipe == 'lainnya') {
            $ram_tipe = $request->ram_tipe_nama;
        } else {
            $ram_tipe = $request->ram_tipe;
        }

        if ($request->ram_kapasitas == 'lainnya') {
            $ram_kapasitas = $request->ram_kapasitas_nama;
        } else {
            $ram_kapasitas = $request->ram_kapasitas;
        }

        if ($request->ram_merek == 'lainnya') {
            $ram_merek = $request->ram_merek_nama;
        } else {
            $ram_merek = $request->ram_merek;
        }

        if ($request->is_ram_tambahan) {
            $is_ram_tambahan = true;
            if ($request->ram_tambahan_kapasitas == 'lainnya') {
                $ram_tambahan_kapasitas = $request->ram_tambahan_kapasitas_nama;
            } else {
                $ram_tambahan_kapasitas = $request->ram_tambahan_kapasitas;
            }
            if ($request->ram_tambahan_merek == 'lainnya') {
                $ram_tambahan_merek = $request->ram_tambahan_merek_nama;
            } else {
                $ram_tambahan_merek = $request->ram_tambahan_merek;
            }
        } else {
            $is_ram_tambahan = false;
            $ram_tambahan_kapasitas = null;
            $ram_tambahan_merek = null;
        }

        if ($request->storage_kapasitas == 'lainnya') {
            $storage_kapasitas = $request->storage_kapasitas_nama;
        } else {
            $storage_kapasitas = $request->storage_kapasitas;
        }

        if ($request->storage_merek == 'lainnya') {
            $storage_merek = $request->storage_merek_nama;
        } else {
            $storage_merek = $request->storage_merek;
        }

        if ($request->is_storage_tambahan) {
            $is_storage_tambahan = true;
            $storage_tambahan_tipe = $request->storage_tambahan_tipe;
            if ($request->storage_tambahan_kapasitas == 'lainnya') {
                $storage_tambahan_kapasitas = $request->storage_tambahan_kapasitas_nama;
            } else {
                $storage_tambahan_kapasitas = $request->storage_tambahan_kapasitas;
            }
            if ($request->storage_tambahan_merek == 'lainnya') {
                $storage_tambahan_merek = $request->storage_tambahan_merek_nama;
            } else {
                $storage_tambahan_merek = $request->storage_tambahan_merek;
            }
        } else {
            $is_storage_tambahan = false;
            $storage_tambahan_tipe = null;
            $storage_tambahan_kapasitas = null;
            $storage_tambahan_merek = null;
        }

        if ($request->jenis == 'pc') {
            $psu_kapasitas = $request->psu_kapasitas;
            $psu_merek = $request->psu_merek;
            $heatsink_merek = $request->heatsink_merek;
            $heatsink_model = $request->heatsink_model;
            $monitor_ukuran = $request->monitor_ukuran;
            $monitor_merek = $request->monitor_merek;
            $keyboard_merek = $request->keyboard_merek;
            $mouse_merek = $request->mouse_merek;
        } else {
            $psu_kapasitas = null;
            $psu_merek = null;
            $heatsink_merek = null;
            $heatsink_model = null;
            $monitor_ukuran = null;
            $monitor_merek = null;
            $keyboard_merek = null;
            $mouse_merek = null;
        }

        $perangkat = Perangkat::create([
            'kode' => strtoupper(Str::random(8)),
            'karyawan_id' => $request->karyawan_id,
            'unit_id' => $request->unit_id,
            'jenis' => $request->jenis,
            'merek' => $merek,
            'model' => $model,
            'no_seri' => $request->no_seri,
            'ram_tipe' => $ram_tipe,
            'ram_kapasitas' => $ram_kapasitas,
            'ram_merek' => $ram_merek,
            'is_ram_tambahan' => $is_ram_tambahan,
            'ram_tambahan_kapasitas' => $ram_tambahan_kapasitas,
            'ram_tambahan_merek' => $ram_tambahan_merek,
            'storage_tipe' => $request->storage_tipe,
            'storage_kapasitas' => $storage_kapasitas,
            'storage_merek' => $storage_merek,
            'is_storage_tambahan' => $is_storage_tambahan,
            'storage_tambahan_tipe' => $storage_tambahan_tipe,
            'storage_tambahan_kapasitas' => $storage_tambahan_kapasitas,
            'storage_tambahan_merek' => $storage_tambahan_merek,
            'psu_merek' => $psu_merek,
            'psu_kapasitas' => $psu_kapasitas,
            'heatsink_merek' => $heatsink_merek,
            'heatsink_model' => $heatsink_model,
            'monitor_ukuran' => $monitor_ukuran,
            'monitor_merek' => $monitor_merek,
            'keyboard_merek' => $keyboard_merek,
            'mouse_merek' => $mouse_merek,
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

        if ($request->ram_tipe == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'tipe'],
                ['keterangan', $ram_tipe]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'tipe',
                    'keterangan' => $ram_tipe,
                ]);
            }
        }

        if ($request->ram_kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'kapasitas'],
                ['keterangan', $ram_kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'kapasitas',
                    'keterangan' => $ram_kapasitas,
                ]);
            }
        }

        if ($request->ram_merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'merek'],
                ['keterangan', $ram_merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'merek',
                    'keterangan' => $ram_merek,
                ]);
            }
        }

        if ($request->is_ram_tambahan) {
            if ($request->ram_tambahan_kapasitas == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'ram'],
                    ['grup', 'kapasitas'],
                    ['keterangan', $ram_tambahan_kapasitas]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'ram',
                        'grup' => 'kapasitas',
                        'keterangan' => $ram_tambahan_kapasitas,
                    ]);
                }
            }
            if ($request->ram_tambahan_merek == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'ram'],
                    ['grup', 'merek'],
                    ['keterangan', $ram_tambahan_merek]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'ram',
                        'grup' => 'merek',
                        'keterangan' => $ram_tambahan_merek,
                    ]);
                }
            }
        }

        if ($request->storage_kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'kapasitas'],
                ['keterangan', $storage_kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'kapasitas',
                    'keterangan' => $storage_kapasitas,
                ]);
            }
        }

        if ($request->storage_merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'merek'],
                ['keterangan', $storage_merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'merek',
                    'keterangan' => $storage_merek,
                ]);
            }
        }

        if ($request->is_storage_tambahan) {
            if ($request->storage_tambahan_kapasitas == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'storage'],
                    ['grup', 'kapasitas'],
                    ['keterangan', $storage_tambahan_kapasitas]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'storage',
                        'grup' => 'kapasitas',
                        'keterangan' => $storage_tambahan_kapasitas,
                    ]);
                }
            }
            if ($request->storage_tambahan_merek == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'storage'],
                    ['grup', 'merek'],
                    ['keterangan', $storage_tambahan_merek]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'storage',
                        'grup' => 'merek',
                        'keterangan' => $storage_tambahan_merek,
                    ]);
                }
            }
        }

        if (!$perangkat) {
            alert()->error('Error', 'Gagal menambahkan Perangkat!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Perangkat');

        return redirect('admin/perangkat');
    }

    public function show($id)
    {
        $perangkat = Perangkat::where('id', $id)
            ->select(
                'id',
                'karyawan_id',
                'unit_id',
                'jenis',
                'merek',
                'model',
                'no_seri',
                'ram_tipe',
                'ram_kapasitas',
                'ram_merek',
                'is_ram_tambahan',
                'ram_tambahan_kapasitas',
                'ram_tambahan_merek',
                'storage_tipe',
                'storage_kapasitas',
                'storage_merek',
                'is_storage_tambahan',
                'storage_tambahan_tipe',
                'storage_tambahan_kapasitas',
                'storage_tambahan_merek',
                'psu_kapasitas',
                'psu_merek',
                'heatsink_model',
                'heatsink_merek',
                'monitor_ukuran',
                'monitor_merek',
                'keyboard_merek',
                'mouse_merek',
                'keterangan',
            )
            ->with('karyawan:id,nama')
            ->with('unit:id,nama')
            ->first();

        $perbaikans = Perbaikan::where('perangkat_id', $id)
            ->select(
                'id',
                'tanggal',
                'keterangan',
            )
            ->with('detail_perbaikans', function ($query) {
                $query->select('perbaikan_id', 'sparepart_id');
                $query->with('sparepart:id,kategori,merek,model,tipe,kapasitas');
            })
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.perangkat.show', compact('perangkat', 'perbaikans'));
    }

    public function edit($id)
    {
        $perangkat = Perangkat::where('id', $id)->select(
            'id',
            'karyawan_id',
            'unit_id',
            'jenis',
            'merek',
            'model',
            'no_seri',
            'ram_tipe',
            'ram_kapasitas',
            'ram_merek',
            'is_ram_tambahan',
            'ram_tambahan_kapasitas',
            'ram_tambahan_merek',
            'storage_tipe',
            'storage_kapasitas',
            'storage_merek',
            'is_storage_tambahan',
            'storage_tambahan_tipe',
            'storage_tambahan_kapasitas',
            'storage_tambahan_merek',
            'psu_kapasitas',
            'psu_merek',
            'heatsink_model',
            'heatsink_merek',
            'monitor_ukuran',
            'monitor_merek',
            'keyboard_merek',
            'mouse_merek',
            'keterangan',
        )
            ->with('karyawan:id,nama')
            ->with('unit:id,nama')
            ->first();
        $karyawans = Karyawan::select('id', 'nama', 'telp', 'bagian_id')
            ->with('bagian', function ($query) {
                $query->select('id', 'unit_id', 'sebagai')->with('unit:id,nama');
            })
            ->limit(10)
            ->orderBy('nama')
            ->get();
        $units = Unit::select('id', 'nama')->get();
        $mereks = Spesifikasi::where([
            ['kategori', 'motherboard'],
            ['grup', 'merek']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $models = Spesifikasi::where([
            ['kategori', 'prosesor'],
            ['grup', 'model']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $ram_tipes = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'tipe']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $ram_kapasitases = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'kapasitas']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $ram_mereks = Spesifikasi::where([
            ['kategori', 'ram'],
            ['grup', 'merek']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $storage_kapasitases = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'kapasitas']
        ])->select('keterangan')->get()->sortBy('keterangan');
        $storage_mereks = Spesifikasi::where([
            ['kategori', 'storage'],
            ['grup', 'merek']
        ])->select('keterangan')->get()->sortBy('keterangan');

        return view('admin.perangkat.edit', compact(
            'perangkat',
            'karyawans',
            'units',
            'mereks',
            'models',
            'ram_tipes',
            'ram_kapasitases',
            'ram_mereks',
            'storage_kapasitases',
            'storage_mereks',
        ));
    }

    public function update1(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'jenis' => 'required',
            'merek' => 'required',
            'model' => 'required',
            'no_seri' => 'required|unique:perangkats,no_seri,' . $id . ',id',
            'ram_tipe' => 'required',
            'ram_kapasitas' => 'required',
            'ram_merek' => 'required',
            'storage_tipe' => 'required',
            'storage_kapasitas' => 'required',
            'storage_merek' => 'required',
        ], [
            'unit_id.required' => 'Unit / Bagian harus dipilih!',
            'jenis.required' => 'Jenis Barang harus dipilih!',
            'merek.required' => 'Merek harus dipilih!',
            'model.required' => 'Model harus dipilih!',
            'no_seri.required' => 'No Seri harus diisi!',
            'no_seri.unique' => 'No Seri sudah digunakan!',
            'ram_tipe.required' => 'Tipe RAM harus dipilih!',
            'ram_kapasitas.required' => 'Kapasitas RAM harus diisi!',
            'ram_merek.required' => 'Merek RAM harus dipilih',
            'storage_tipe.required' => 'Tipe Storage harus dipilih!',
            'storage_kapasitas.required' => 'Kapasitas Storage harus diisi!',
            'storage_merek.required' => 'Merek Storage harus dipilih!',
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

        $error_ram = array();
        $validator_fails_ram = false;
        if ($request->is_ram_tambahan) {
            $validator_ram = Validator::make($request->all(), [
                'ram_tambahan_kapasitas' => 'required',
                'ram_tambahan_merek' => 'required',
            ], [
                'ram_tambahan_kapasitas.required' => 'Kapasitas RAM harus diisi!',
                'ram_tambahan_merek.required' => 'Merek RAM harus dipilih',
            ]);

            $error_ram = $validator_ram->errors();
            $validator_fails_ram = $validator_ram->fails();
        }

        $error_storage = array();
        $validator_fails_storage = false;
        if ($request->is_storage_tambahan) {
            $validator_storage = Validator::make($request->all(), [
                'storage_tambahan_tipe' => 'required',
                'storage_tambahan_kapasitas' => 'required',
                'storage_tambahan_merek' => 'required',
            ], [
                'storage_tambahan_tipe.required' => 'Tipe Storage harus dipilih!',
                'storage_tambahan_kapasitas.required' => 'Kapasitas Storage harus diisi!',
                'storage_tambahan_merek.required' => 'Merek Storage harus diisi',
            ]);

            $error_storage = $validator_storage->errors();
            $validator_fails_storage = $validator_storage->fails();
        }

        $error_jenis_pc = array();
        $validator_fails_jenis_pc = false;
        if ($request->jenis == 'pc') {
            $validator_jenis_pc = Validator::make($request->all(), [
                'psu_kapasitas' => 'required',
                'psu_merek' => 'required',
                'heatsink_merek' => 'required',
                'heatsink_model' => 'required',
                'monitor_ukuran' => 'required',
                'monitor_merek' => 'required',
                'keyboard_merek' => 'required',
                'mouse_merek' => 'required',
            ], [
                'psu_kapasitas.required' => 'Kapasitas PSU harus diisi!',
                'psu_merek.required' => 'Merek PSU harus diisi!',
                'heatsink_merek.required' => 'Merek Heatsink harus diisi',
                'heatsink_model.required' => 'Model Heatsink harus diisi',
                'monitor_ukuran.required' => 'Ukuran Monitor harus diisi',
                'monitor_merek.required' => 'Merek Monitor harus diisi',
                'keyboard_merek.required' => 'Merek Keyboard harus diisi',
                'mouse_merek.required' => 'Merek Mouse harus diisi',
            ]);

            $error_jenis_pc = $validator_jenis_pc->errors();
            $validator_fails_jenis_pc = $validator_jenis_pc->fails();
        }

        if ($validator->fails() || $validator_fails_model || $validator_fails_ram || $validator_fails_storage || $validator_fails_jenis_pc) {
            alert()->error('Error', 'Gagal menambahkan Perangkat!');
            return back()->withInput()
                ->withErrors($validator->errors()->merge($error_model)->merge($error_ram)->merge($error_storage)->merge($error_jenis_pc));
        }

        if ($request->model == 'lainnya') {
            $model = $request->model_nama;
        } else {
            $model = $request->model;
        }

        if ($request->is_ram_tambahan) {
            $is_ram_tambahan = true;
            $ram_tambahan_kapasitas = $request->ram_tambahan_kapasitas;
            $ram_tambahan_merek = $request->ram_tambahan_merek;
        } else {
            $is_ram_tambahan = false;
            $ram_tambahan_kapasitas = null;
            $ram_tambahan_merek = null;
        }

        if ($request->is_storage_tambahan) {
            $is_storage_tambahan = true;
            $storage_tambahan_tipe = $request->storage_tambahan_tipe;
            $storage_tambahan_kapasitas = $request->storage_tambahan_kapasitas;
            $storage_tambahan_merek = $request->storage_tambahan_merek;
        } else {
            $is_storage_tambahan = false;
            $storage_tambahan_tipe = null;
            $storage_tambahan_kapasitas = null;
            $storage_tambahan_merek = null;
        }

        if ($request->jenis == 'pc') {
            $psu_kapasitas = $request->psu_kapasitas;
            $psu_merek = $request->psu_merek;
            $heatsink_merek = $request->heatsink_merek;
            $heatsink_model = $request->heatsink_model;
            $monitor_ukuran = $request->monitor_ukuran;
            $monitor_merek = $request->monitor_merek;
            $keyboard_merek = $request->keyboard_merek;
            $mouse_merek = $request->mouse_merek;
        } else {
            $psu_kapasitas = null;
            $psu_merek = null;
            $heatsink_merek = null;
            $heatsink_model = null;
            $monitor_ukuran = null;
            $monitor_merek = null;
            $keyboard_merek = null;
            $mouse_merek = null;
        }

        $perangkat = Perangkat::where('id', $id)->update([
            'karyawan_id' => $request->karyawan_id,
            'unit_id' => $request->unit_id,
            'jenis' => $request->jenis,
            'merek' => $request->merek,
            'model' => $model,
            'no_seri' => $request->no_seri,
            'ram_tipe' => $request->ram_tipe,
            'ram_kapasitas' => $request->ram_kapasitas,
            'ram_merek' => $request->ram_merek,
            'is_ram_tambahan' => $is_ram_tambahan,
            'ram_tambahan_kapasitas' => $ram_tambahan_kapasitas,
            'ram_tambahan_merek' => $ram_tambahan_merek,
            'storage_tipe' => $request->storage_tipe,
            'storage_kapasitas' => $request->storage_kapasitas,
            'storage_merek' => $request->storage_merek,
            'is_storage_tambahan' => $is_storage_tambahan,
            'storage_tambahan_tipe' => $storage_tambahan_tipe,
            'storage_tambahan_kapasitas' => $storage_tambahan_kapasitas,
            'storage_tambahan_merek' => $storage_tambahan_merek,
            'psu_merek' => $psu_merek,
            'psu_kapasitas' => $psu_kapasitas,
            'heatsink_merek' => $heatsink_merek,
            'heatsink_model' => $heatsink_model,
            'monitor_ukuran' => $monitor_ukuran,
            'monitor_merek' => $monitor_merek,
            'keyboard_merek' => $keyboard_merek,
            'mouse_merek' => $mouse_merek,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->model == 'lainnya') {
            Spesifikasi::create([
                'kategori' => 'prosesor',
                'nama' => $model,
            ]);
        }

        if (!$perangkat) {
            alert()->error('Error', 'Gagal menambahkan Perangkat!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Perangkat');

        return redirect('admin/perangkat');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'jenis' => 'required',
            'merek' => 'required',
            'model' => 'required',
            'no_seri' => 'required|unique:perangkats,no_seri,' . $id . ',id',
            'ram_tipe' => 'required',
            'ram_kapasitas' => 'required',
            'ram_merek' => 'required',
            'storage_tipe' => 'required',
            'storage_kapasitas' => 'required',
            'storage_merek' => 'required',
        ], [
            'unit_id.required' => 'Unit / Bagian harus dipilih!',
            'jenis.required' => 'Jenis Barang harus dipilih!',
            'merek.required' => 'Merek harus dipilih!',
            'model.required' => 'Model harus dipilih!',
            'no_seri.required' => 'No Seri harus diisi!',
            'no_seri.unique' => 'No Seri sudah digunakan!',
            'ram_tipe.required' => 'Tipe RAM harus dipilih!',
            'ram_kapasitas.required' => 'Kapasitas RAM harus diisi!',
            'ram_merek.required' => 'Merek RAM harus dipilih',
            'storage_tipe.required' => 'Tipe Storage harus dipilih!',
            'storage_kapasitas.required' => 'Kapasitas Storage harus diisi!',
            'storage_merek.required' => 'Merek Storage harus dipilih!',
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
                'model_nama.required' => 'Nama Model harus diisi!',
            ]);

            $error_model = $validator_model->errors();
            $validator_fails_model = $validator_model->fails();
        }

        $error_ram_tipe = array();
        $validator_fails_ram_tipe = false;
        if ($request->ram_tipe == 'lainnya') {
            $validator_ram_tipe = Validator::make($request->all(), [
                'ram_tipe_nama' => 'required',
            ], [
                'ram_tipe_nama.required' => 'Tipe RAM harus diisi!',
            ]);

            $error_ram_tipe = $validator_ram_tipe->errors();
            $validator_fails_ram_tipe = $validator_ram_tipe->fails();
        }

        $error_ram_kapasitas = array();
        $validator_fails_ram_kapasitas = false;
        if ($request->ram_kapasitas == 'lainnya') {
            $validator_ram_kapasitas = Validator::make($request->all(), [
                'ram_kapasitas_nama' => 'required',
            ], [
                'ram_kapasitas_nama.required' => 'Kapasitas RAM harus diisi!',
            ]);

            $error_ram_kapasitas = $validator_ram_kapasitas->errors();
            $validator_fails_ram_kapasitas = $validator_ram_kapasitas->fails();
        }

        $error_ram_merek = array();
        $validator_fails_ram_merek = false;
        if ($request->ram_merek == 'lainnya') {
            $validator_ram_merek = Validator::make($request->all(), [
                'ram_merek_nama' => 'required',
            ], [
                'ram_merek_nama.required' => 'Merek RAM harus diisi!',
            ]);

            $error_ram_merek = $validator_ram_merek->errors();
            $validator_fails_ram_merek = $validator_ram_merek->fails();
        }

        $error_ram_tambahan_kapasitas = array();
        $validator_fails_ram_tambahan_kapasitas = false;
        if ($request->is_ram_tambahan) {
            if ($request->ram_tambahan_kapasitas == 'lainnya') {
                $validator_ram_tambahan_kapasitas = Validator::make($request->all(), [
                    'ram_tambahan_kapasitas_nama' => 'required',
                ], [
                    'ram_tambahan_kapasitas_nama.required' => 'Kapasitas RAM harus diisi!',
                ]);

                $error_ram_tambahan_kapasitas = $validator_ram_tambahan_kapasitas->errors();
                $validator_fails_ram_tambahan_kapasitas = $validator_ram_tambahan_kapasitas->fails();
            }
        }

        $error_ram_tambahan_merek = array();
        $validator_fails_ram_tambahan_merek = false;
        if ($request->is_ram_tambahan) {
            if ($request->ram_tambahan_merek == 'lainnya') {
                $validator_ram_tambahan_merek = Validator::make($request->all(), [
                    'ram_tambahan_merek_nama' => 'required',
                ], [
                    'ram_tambahan_merek_nama.required' => 'Merek RAM harus diisi!',
                ]);

                $error_ram_tambahan_merek = $validator_ram_tambahan_merek->errors();
                $validator_fails_ram_tambahan_merek = $validator_ram_tambahan_merek->fails();
            }
        }

        $error_storage_kapasitas = array();
        $validator_fails_storage_kapasitas = false;
        if ($request->storage_kapasitas == 'lainnya') {
            $validator_storage_kapasitas = Validator::make($request->all(), [
                'storage_kapasitas_nama' => 'required',
            ], [
                'storage_kapasitas_nama.required' => 'Kapasitas Storage harus diisi!',
            ]);

            $error_storage_kapasitas = $validator_storage_kapasitas->errors();
            $validator_fails_storage_kapasitas = $validator_storage_kapasitas->fails();
        }

        $error_storage_merek = array();
        $validator_fails_storage_merek = false;
        if ($request->storage_merek == 'lainnya') {
            $validator_storage_merek = Validator::make($request->all(), [
                'storage_merek_nama' => 'required',
            ], [
                'storage_merek_nama.required' => 'Merek Storage harus diisi!',
            ]);

            $error_storage_merek = $validator_storage_merek->errors();
            $validator_fails_storage_merek = $validator_storage_merek->fails();
        }

        $error_storage_tambahan_kapasitas = array();
        $validator_fails_storage_tambahan_kapasitas = false;
        if ($request->is_storage_tambahan) {
            if ($request->storage_tambahan_kapasitas == 'lainnya') {
                $validator_storage_tambahan_kapasitas = Validator::make($request->all(), [
                    'storage_tambahan_kapasitas_nama' => 'required',
                ], [
                    'storage_tambahan_kapasitas_nama.required' => 'Kapasitas Storage harus diisi!',
                ]);

                $error_storage_tambahan_kapasitas = $validator_storage_tambahan_kapasitas->errors();
                $validator_fails_storage_tambahan_kapasitas = $validator_storage_tambahan_kapasitas->fails();
            }
        }

        $error_storage_tambahan_merek = array();
        $validator_fails_storage_tambahan_merek = false;
        if ($request->is_storage_tambahan) {
            if ($request->storage_tambahan_merek == 'lainnya') {
                $validator_storage_tambahan_merek = Validator::make($request->all(), [
                    'storage_tambahan_merek_nama' => 'required',
                ], [
                    'storage_tambahan_merek_nama.required' => 'Merek Storage harus diisi!',
                ]);

                $error_storage_tambahan_merek = $validator_storage_tambahan_merek->errors();
                $validator_fails_storage_tambahan_merek = $validator_storage_tambahan_merek->fails();
            }
        }

        $error_jenis_pc = array();
        $validator_fails_jenis_pc = false;
        if ($request->jenis == 'pc') {
            $validator_jenis_pc = Validator::make($request->all(), [
                'psu_kapasitas' => 'required',
                'psu_merek' => 'required',
                'heatsink_merek' => 'required',
                'heatsink_model' => 'required',
                'monitor_ukuran' => 'required',
                'monitor_merek' => 'required',
                'keyboard_merek' => 'required',
                'mouse_merek' => 'required',
            ], [
                'psu_kapasitas.required' => 'Kapasitas PSU harus diisi!',
                'psu_merek.required' => 'Merek PSU harus diisi!',
                'heatsink_merek.required' => 'Merek Heatsink harus diisi',
                'heatsink_model.required' => 'Model Heatsink harus diisi',
                'monitor_ukuran.required' => 'Ukuran Monitor harus diisi',
                'monitor_merek.required' => 'Merek Monitor harus diisi',
                'keyboard_merek.required' => 'Merek Keyboard harus diisi',
                'mouse_merek.required' => 'Merek Mouse harus diisi',
            ]);

            $error_jenis_pc = $validator_jenis_pc->errors();
            $validator_fails_jenis_pc = $validator_jenis_pc->fails();
        }

        if (
            $validator->fails() ||
            $validator_fails_merek ||
            $validator_fails_model ||
            $validator_fails_ram_tipe ||
            $validator_fails_ram_kapasitas ||
            $validator_fails_ram_merek ||
            $validator_fails_ram_tambahan_kapasitas ||
            $validator_fails_ram_tambahan_merek ||
            $validator_fails_storage_kapasitas ||
            $validator_fails_storage_merek ||
            $validator_fails_storage_tambahan_kapasitas ||
            $validator_fails_storage_tambahan_merek ||
            $validator_fails_jenis_pc
        ) {
            alert()->error('Error', 'Gagal memperbarui Perangkat!');
            return back()->withInput()
                ->withErrors(
                    $validator->errors()
                        ->merge($error_merek)
                        ->merge($error_model)
                        ->merge($error_ram_tipe)
                        ->merge($error_ram_kapasitas)
                        ->merge($error_ram_merek)
                        ->merge($error_ram_tambahan_kapasitas)
                        ->merge($error_ram_tambahan_merek)
                        ->merge($error_storage_kapasitas)
                        ->merge($error_storage_merek)
                        ->merge($error_storage_tambahan_kapasitas)
                        ->merge($error_storage_tambahan_merek)
                        ->merge($error_jenis_pc)
                );
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

        if ($request->ram_tipe == 'lainnya') {
            $ram_tipe = $request->ram_tipe_nama;
        } else {
            $ram_tipe = $request->ram_tipe;
        }

        if ($request->ram_kapasitas == 'lainnya') {
            $ram_kapasitas = $request->ram_kapasitas_nama;
        } else {
            $ram_kapasitas = $request->ram_kapasitas;
        }

        if ($request->ram_merek == 'lainnya') {
            $ram_merek = $request->ram_merek_nama;
        } else {
            $ram_merek = $request->ram_merek;
        }

        if ($request->is_ram_tambahan) {
            $is_ram_tambahan = true;
            if ($request->ram_tambahan_kapasitas == 'lainnya') {
                $ram_tambahan_kapasitas = $request->ram_tambahan_kapasitas_nama;
            } else {
                $ram_tambahan_kapasitas = $request->ram_tambahan_kapasitas;
            }
            if ($request->ram_tambahan_merek == 'lainnya') {
                $ram_tambahan_merek = $request->ram_tambahan_merek_nama;
            } else {
                $ram_tambahan_merek = $request->ram_tambahan_merek;
            }
        } else {
            $is_ram_tambahan = false;
            $ram_tambahan_kapasitas = null;
            $ram_tambahan_merek = null;
        }

        if ($request->storage_kapasitas == 'lainnya') {
            $storage_kapasitas = $request->storage_kapasitas_nama;
        } else {
            $storage_kapasitas = $request->storage_kapasitas;
        }

        if ($request->storage_merek == 'lainnya') {
            $storage_merek = $request->storage_merek_nama;
        } else {
            $storage_merek = $request->storage_merek;
        }

        if ($request->is_storage_tambahan) {
            $is_storage_tambahan = true;
            $storage_tambahan_tipe = $request->storage_tambahan_tipe;
            if ($request->storage_tambahan_kapasitas == 'lainnya') {
                $storage_tambahan_kapasitas = $request->storage_tambahan_kapasitas_nama;
            } else {
                $storage_tambahan_kapasitas = $request->storage_tambahan_kapasitas;
            }
            if ($request->storage_tambahan_merek == 'lainnya') {
                $storage_tambahan_merek = $request->storage_tambahan_merek_nama;
            } else {
                $storage_tambahan_merek = $request->storage_tambahan_merek;
            }
        } else {
            $is_storage_tambahan = false;
            $storage_tambahan_tipe = null;
            $storage_tambahan_kapasitas = null;
            $storage_tambahan_merek = null;
        }

        if ($request->jenis == 'pc') {
            $psu_kapasitas = $request->psu_kapasitas;
            $psu_merek = $request->psu_merek;
            $heatsink_merek = $request->heatsink_merek;
            $heatsink_model = $request->heatsink_model;
            $monitor_ukuran = $request->monitor_ukuran;
            $monitor_merek = $request->monitor_merek;
            $keyboard_merek = $request->keyboard_merek;
            $mouse_merek = $request->mouse_merek;
        } else {
            $psu_kapasitas = null;
            $psu_merek = null;
            $heatsink_merek = null;
            $heatsink_model = null;
            $monitor_ukuran = null;
            $monitor_merek = null;
            $keyboard_merek = null;
            $mouse_merek = null;
        }

        $perangkat = Perangkat::where('id', $id)->update([
            'karyawan_id' => $request->karyawan_id,
            'unit_id' => $request->unit_id,
            'jenis' => $request->jenis,
            'merek' => $merek,
            'model' => $model,
            'no_seri' => $request->no_seri,
            'ram_tipe' => $ram_tipe,
            'ram_kapasitas' => $ram_kapasitas,
            'ram_merek' => $ram_merek,
            'is_ram_tambahan' => $is_ram_tambahan,
            'ram_tambahan_kapasitas' => $ram_tambahan_kapasitas,
            'ram_tambahan_merek' => $ram_tambahan_merek,
            'storage_tipe' => $request->storage_tipe,
            'storage_kapasitas' => $storage_kapasitas,
            'storage_merek' => $storage_merek,
            'is_storage_tambahan' => $is_storage_tambahan,
            'storage_tambahan_tipe' => $storage_tambahan_tipe,
            'storage_tambahan_kapasitas' => $storage_tambahan_kapasitas,
            'storage_tambahan_merek' => $storage_tambahan_merek,
            'psu_merek' => $psu_merek,
            'psu_kapasitas' => $psu_kapasitas,
            'heatsink_merek' => $heatsink_merek,
            'heatsink_model' => $heatsink_model,
            'monitor_ukuran' => $monitor_ukuran,
            'monitor_merek' => $monitor_merek,
            'keyboard_merek' => $keyboard_merek,
            'mouse_merek' => $mouse_merek,
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

        if ($request->ram_tipe == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'tipe'],
                ['keterangan', $ram_tipe]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'tipe',
                    'keterangan' => $ram_tipe,
                ]);
            }
        }

        if ($request->ram_kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'kapasitas'],
                ['keterangan', $ram_kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'kapasitas',
                    'keterangan' => $ram_kapasitas,
                ]);
            }
        }

        if ($request->ram_merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'ram'],
                ['grup', 'merek'],
                ['keterangan', $ram_merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'ram',
                    'grup' => 'merek',
                    'keterangan' => $ram_merek,
                ]);
            }
        }

        if ($request->is_ram_tambahan) {
            if ($request->ram_tambahan_kapasitas == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'ram'],
                    ['grup', 'kapasitas'],
                    ['keterangan', $ram_tambahan_kapasitas]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'ram',
                        'grup' => 'kapasitas',
                        'keterangan' => $ram_tambahan_kapasitas,
                    ]);
                }
            }
            if ($request->ram_tambahan_merek == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'ram'],
                    ['grup', 'merek'],
                    ['keterangan', $ram_tambahan_merek]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'ram',
                        'grup' => 'merek',
                        'keterangan' => $ram_tambahan_merek,
                    ]);
                }
            }
        }

        if ($request->storage_kapasitas == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'kapasitas'],
                ['keterangan', $storage_kapasitas]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'kapasitas',
                    'keterangan' => $storage_kapasitas,
                ]);
            }
        }

        if ($request->storage_merek == 'lainnya') {
            $cek = Spesifikasi::where([
                ['kategori', 'storage'],
                ['grup', 'merek'],
                ['keterangan', $storage_merek]
            ])->exists();
            if (!$cek) {
                Spesifikasi::create([
                    'kategori' => 'storage',
                    'grup' => 'merek',
                    'keterangan' => $storage_merek,
                ]);
            }
        }

        if ($request->is_storage_tambahan) {
            if ($request->storage_tambahan_kapasitas == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'storage'],
                    ['grup', 'kapasitas'],
                    ['keterangan', $storage_tambahan_kapasitas]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'storage',
                        'grup' => 'kapasitas',
                        'keterangan' => $storage_tambahan_kapasitas,
                    ]);
                }
            }
            if ($request->storage_tambahan_merek == 'lainnya') {
                $cek = Spesifikasi::where([
                    ['kategori', 'storage'],
                    ['grup', 'merek'],
                    ['keterangan', $storage_tambahan_merek]
                ])->exists();
                if (!$cek) {
                    Spesifikasi::create([
                        'kategori' => 'storage',
                        'grup' => 'merek',
                        'keterangan' => $storage_tambahan_merek,
                    ]);
                }
            }
        }

        if (!$perangkat) {
            alert()->error('Error', 'Gagal memperbarui Perangkat!');
            return back();
        }

        alert()->success('Success', 'Berhasil memperbarui Perangkat');

        return redirect('admin/perangkat');
    }

    public function destroy($id)
    {
        $perangkat = Perangkat::where('id', $id)->delete();

        if (!$perangkat) {
            alert()->error('Error', 'Gagal menghapus Perangkat!');
            return back();
        }

        alert()->success('Success', 'Berhasil menghapus Perangkat');
    }

    public function print($id)
    {
        return view('error.500');

        $kode = Perangkat::where('id', $id)->value('kode');
        $pdf = Pdf::loadview('admin.perangkat.print', compact('kode'));
        return $pdf->stream('Kode Perangkat');
    }

    public function scan()
    {
        return view('admin.perangkat.scan');
    }

    public function scan_proses(Request $request)
    {
        $perangkat = Perangkat::where('kode', $request->kode)->first();

        if (!$perangkat) {
            alert()->info('Error', 'Perangkat tidak ditemukan!');
            return back();
        }

        return $this->edit($perangkat->id);
    }

    public function karyawan_set($id)
    {
        $karyawan = Karyawan::where('id', $id)
            ->select('id', 'nama', 'bagian_id')
            ->with('bagian:id,unit_id')
            ->first();

        return $karyawan;
    }

    public function karyawan_search(Request $request)
    {
        $keyword = $request->keyword;
        $karyawans = Karyawan::where('nama', 'like', "%$keyword%")
            ->select('id', 'nama', 'bagian_id')
            ->with('bagian', function ($query) {
                $query->select('id', 'unit_id', 'sebagai')->with('unit:id,nama');
            })
            ->orderBy('nama')
            ->take(10)
            ->get();

        return $karyawans;
    }
}
