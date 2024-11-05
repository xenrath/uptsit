<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPerbaikan;
use App\Models\Perangkat;
use App\Models\Perbaikan;
use App\Models\Sparepart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PerbaikanController extends Controller
{
    public function index()
    {
        $perbaikans = Perbaikan::get();
        $perangkats = Perangkat::select(
            'id',
            'karyawan_id',
            'unit_id'
        )
            ->with('karyawan:id,nama')
            ->with('unit:id,nama')
            ->limit(10)
            ->get()
            ->sortBy('karyawan.nama');

        return view('admin.perbaikan.index', compact('perbaikans', 'perangkats'));
    }

    public function create()
    {
        $perangkats = Perangkat::select(
            'id',
            'karyawan_id',
            'unit_id'
        )
            ->with('karyawan:id,nama')
            ->with('unit:id,nama')
            ->get();
        $motherboards = Sparepart::where([
            ['kategori', 'motherboard'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'model',
                'tipe',
                'is_baru'
            )
            ->get();
        $prosesors = Sparepart::where([
            ['kategori', 'prosesor'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'model',
                'is_baru'
            )
            ->get();
        $rams = Sparepart::where([
            ['kategori', 'ram'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'tipe',
                'kapasitas',
                'is_baru'
            )
            ->get();
        $storages = Sparepart::where([
            ['kategori', 'storage'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'tipe',
                'kapasitas',
                'is_baru'
            )
            ->get();
        $psus = Sparepart::where([
            ['kategori', 'psu'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'kapasitas',
                'is_baru'
            )
            ->get();

        return view('admin.perbaikan.create', compact(
            'perangkats',
            'motherboards',
            'prosesors',
            'rams',
            'storages',
            'psus',
        ));
    }

    public function show($id)
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
        $motherboards = Sparepart::where([
            ['kategori', 'motherboard'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'model',
                'tipe',
                'is_baru'
            )
            ->get();
        $prosesors = Sparepart::where([
            ['kategori', 'prosesor'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'model',
                'is_baru'
            )
            ->get();
        $rams = Sparepart::where([
            ['kategori', 'ram'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'tipe',
                'kapasitas',
                'is_baru'
            )
            ->get();
        $storages = Sparepart::where([
            ['kategori', 'storage'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'tipe',
                'kapasitas',
                'is_baru'
            )
            ->get();
        $psus = Sparepart::where([
            ['kategori', 'psu'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'kapasitas',
                'is_baru'
            )
            ->get();
        $heatsinks = Sparepart::where([
            ['kategori', 'heatsink'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'model',
                'is_baru'
            )
            ->get();
        $monitors = Sparepart::where([
            ['kategori', 'monitor'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'kapasitas',
                'is_baru'
            )
            ->get();
        $keyboards = Sparepart::where([
            ['kategori', 'keyboard'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'is_baru'
            )
            ->get();
        $mouses = Sparepart::where([
            ['kategori', 'mouse'],
            ['jumlah', '>', '0']
        ])
            ->select(
                'id',
                'merek',
                'is_baru'
            )
            ->get();

        return view('admin.perbaikan.show', compact(
            'perangkat',
            'motherboards',
            'prosesors',
            'rams',
            'storages',
            'psus',
            'heatsinks',
            'monitors',
            'keyboards',
            'mouses',
        ));
    }

    public function store(Request $request)
    {
        $perangkat = Perangkat::where('id', $request->perangkat_id)->first();

        $validator = Validator::make($request->all(), [
            'perangkat_id' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
            'foto_sebelum' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'foto_sesudah' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'paraf' => 'required',
        ], [
            'perangkat_id.required' => 'Perangkat tidak ditemukan!',
            'tanggal.required' => 'Tanggal Perbaikan harus dipilih!',
            'keterangan.required' => 'Tindakan harus diisi!',
            'foto_sebelum.required' => 'Foto harus ditambahkan!',
            'foto_sebelum.image' => 'Foto harus berformat jpeg, jpg, png!',
            'foto_sebelum.mimes' => 'Foto harus berformat jpeg, jpg, png!',
            'foto_sebelum.max' => 'Foto maksimal ukuran 2 MB!',
            'foto_sesudah.required' => 'Foto harus ditambahkan!',
            'foto_sesudah.mimes' => 'Foto harus berformat jpeg, jpg, png!',
            'foto_sesudah.max' => 'Foto maksimal ukuran 2 MB!',
            'paraf.required' => 'Paraf harus diisi!',
        ]);

        $error_ram_tambahan = array();
        $validator_fails_ram_tambahan = false;
        $perangkat_is_ram_tambahan = $perangkat->is_ram_tambahan ?? null;
        if ($request->is_ram_tambahan) {
            if (!$perangkat_is_ram_tambahan) {
                $validator_ram_tambahan = Validator::make($request->all(), [
                    'ram_tambahan_id' => 'required',
                ], [
                    'ram_tambahan_id.required' => 'RAM Tambahan harus dipilih!',
                ]);

                $error_ram_tambahan = $validator_ram_tambahan->errors();
                $validator_fails_ram_tambahan = $validator_ram_tambahan->fails();
            }
        }

        $error_storage_tambahan = array();
        $validator_fails_storage_tambahan = false;
        $perangkat_is_storage_tambahan = $perangkat->is_storage_tambahan ?? null;
        if ($request->is_storage_tambahan) {
            if (!$perangkat_is_storage_tambahan) {
                $validator_storage_tambahan = Validator::make($request->all(), [
                    'storage_tambahan_id' => 'required',
                ], [
                    'storage_tambahan_id.required' => 'Storage Tambahan harus dipilih!',
                ]);

                $error_storage_tambahan = $validator_storage_tambahan->errors();
                $validator_fails_storage_tambahan = $validator_storage_tambahan->fails();
            }
        }

        if ($validator->fails() || $validator_fails_ram_tambahan || $validator_fails_storage_tambahan) {
            alert()->error('Error', 'Gagal menambahkan Perbaikan!');
            return back()->withInput()
                ->withErrors($validator->errors()->merge($error_ram_tambahan)->merge($error_storage_tambahan));
        }

        $waktu = Carbon::now()->format('ymdhis');

        $foto_sebelum = 'perbaikan/foto_sebelum_' . $waktu . '.' . $request->foto_sebelum->getClientOriginalExtension();
        $request->foto_sebelum->storeAs('public/uploads/', $foto_sebelum);

        $foto_sesudah = 'perbaikan/foto_sesudah_' . $waktu . '.' . $request->foto_sesudah->getClientOriginalExtension();
        $request->foto_sesudah->storeAs('public/uploads/', $foto_sesudah);

        $paraf = str_replace('data:image/png;base64,', '', $request->paraf);
        $paraf = str_replace(' ', '+', $paraf);
        $namaparaf = 'perbaikan/paraf_' . $waktu . '.' . 'png';
        File::put(public_path('storage/uploads') . '/' . $namaparaf, base64_decode($paraf));

        $perbaikan = Perbaikan::create([
            'perangkat_id' => $perangkat->id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'foto_sebelum' => $foto_sebelum,
            'foto_sesudah' => $foto_sesudah,
            'paraf' => $namaparaf,
        ]);

        if ($perbaikan) {
            if ($request->motherboard_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->motherboard_id
                ]);

                $jumlah =  Sparepart::where('id', $request->motherboard_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->motherboard_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'motherboard'],
                    ['merek', $perangkat->merek],
                    ['model', $perangkat->model],
                    ['tipe', $perangkat->tipe],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'motherboard',
                        'merek' => $perangkat->merek,
                        'model' => $perangkat->model,
                        'tipe' => $perangkat->tipe,
                        'jumlah' => 1,
                    ]);
                }
            }

            if ($request->prosesor_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->prosesor_id
                ]);

                $jumlah =  Sparepart::where('id', $request->prosesor_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->prosesor_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'prosesor'],
                    ['model', $perangkat->model],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'prosesor',
                        'model' => $perangkat->model,
                        'jumlah' => 1,
                    ]);
                }
            }

            if ($request->ram_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->ram_id
                ]);

                $jumlah =  Sparepart::where('id', $request->ram_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->ram_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'ram'],
                    ['tipe', $perangkat->ram_tipe],
                    ['merek', $perangkat->ram_merek],
                    ['kapasitas', $perangkat->ram_kapasitas],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'ram',
                        'tipe' => $perangkat->ram_tipe,
                        'merek' => $perangkat->ram_merek,
                        'kapasitas' => $perangkat->ram_kapasitas,
                        'jumlah' => 1,
                    ]);
                }
            }

            if ($request->is_ram_tambahan) {
                if ($request->ram_tambahan_id) {
                    DetailPerbaikan::create([
                        'perbaikan_id' => $perbaikan->id,
                        'sparepart_id' => $request->ram_tambahan_id
                    ]);

                    $jumlah =  Sparepart::where('id', $request->ram_id)->value('jumlah') - 1;
                    Sparepart::where('id', $request->ram_id)->update([
                        'jumlah' => $jumlah
                    ]);

                    if ($perangkat->is_ram_tambahan) {
                        $sparepart = Sparepart::where([
                            ['kategori', 'ram'],
                            ['tipe', $perangkat->ram_tipe],
                            ['merek', $perangkat->ram_tambahan_merek],
                            ['kapasitas', $perangkat->ram_tambahan_kapasitas],
                            ['is_baru', false],
                        ])->first();

                        if ($sparepart) {
                            Sparepart::where('id', $sparepart->id)->update([
                                'jumlah' => $sparepart->jumlah + 1,
                            ]);
                        } else {
                            Sparepart::create([
                                'kategori' => 'ram',
                                'tipe' => $perangkat->ram_tipe,
                                'merek' => $perangkat->ram_tambahan_merek,
                                'kapasitas' => $perangkat->ram_tambahan_kapasitas,
                                'jumlah' => 1,
                            ]);
                        }
                    }
                }
            }

            if ($request->storage_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->storage_id
                ]);

                $jumlah =  Sparepart::where('id', $request->storage_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->storage_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'storage'],
                    ['tipe', $perangkat->storage_tipe],
                    ['merek', $perangkat->storage_merek],
                    ['kapasitas', $perangkat->storage_kapasitas],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'storage',
                        'tipe' => $perangkat->storage_tipe,
                        'merek' => $perangkat->storage_merek,
                        'kapasitas' => $perangkat->storage_kapasitas,
                        'jumlah' => 1
                    ]);
                }
            }

            if ($request->is_storage_tambahan) {
                if ($request->storage_tambahan_id) {
                    DetailPerbaikan::create([
                        'perbaikan_id' => $perbaikan->id,
                        'sparepart_id' => $request->storage_tambahan_id
                    ]);

                    $jumlah =  Sparepart::where('id', $request->storage_id)->value('jumlah') - 1;
                    Sparepart::where('id', $request->storage_id)->update([
                        'jumlah' => $jumlah
                    ]);

                    if ($perangkat->is_storage_tambahan) {
                        $sparepart = Sparepart::where([
                            ['kategori', 'storage'],
                            ['tipe', $perangkat->storage_tambahan_tipe],
                            ['merek', $perangkat->storage_tambahan_merek],
                            ['kapasitas', $perangkat->storage_tambahan_kapasitas],
                            ['is_baru', false],
                        ])->first();

                        if ($sparepart) {
                            Sparepart::where('id', $sparepart->id)->update([
                                'jumlah' => $sparepart->jumlah + 1,
                            ]);
                        } else {
                            Sparepart::create([
                                'kategori' => 'storage',
                                'tipe' => $perangkat->storage_tambahan_tipe,
                                'merek' => $perangkat->storage_tambahan_merek,
                                'kapasitas' => $perangkat->storage_tambahan_kapasitas,
                                'jumlah' => 1,
                            ]);
                        }
                    }
                }
            }

            if ($request->psu_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->psu_id
                ]);

                $jumlah =  Sparepart::where('id', $request->psu_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->psu_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'psu'],
                    ['merek', $perangkat->psu_merek],
                    ['kapasitas', $perangkat->psu_kapasitas],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'psu',
                        'merek' => $perangkat->psu_merek,
                        'kapasitas' => $perangkat->psu_kapasitas,
                        'jumlah' => 1,
                    ]);
                }
            }

            if ($request->heatsink_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->heatsink_id
                ]);

                $jumlah =  Sparepart::where('id', $request->heatsink_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->heatsink_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'heatsink'],
                    ['merek', $perangkat->heatsink_merek],
                    ['model', $perangkat->heatsink_model],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'heatsink',
                        'merek' => $perangkat->heatsink_merek,
                        'model' => $perangkat->heatsink_model,
                        'jumlah' => 1,
                    ]);
                }
            }

            if ($request->monitor_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->monitor_id
                ]);

                $jumlah =  Sparepart::where('id', $request->monitor_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->monitor_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'monitor'],
                    ['merek', $perangkat->monitor_merek],
                    ['model', $perangkat->monitor_model],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'monitor',
                        'merek' => $perangkat->monitor_merek,
                        'model' => $perangkat->monitor_model,
                        'jumlah' => 1,
                    ]);
                }
            }

            if ($request->keyboard_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->keyboard_id
                ]);

                $jumlah =  Sparepart::where('id', $request->keyboard_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->keyboard_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'keyboard'],
                    ['merek', $perangkat->keyboard_merek],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'keyboard',
                        'merek' => $perangkat->keyboard_merek,
                        'jumlah' => 1,
                    ]);
                }
            }

            if ($request->mouse_id) {
                DetailPerbaikan::create([
                    'perbaikan_id' => $perbaikan->id,
                    'sparepart_id' => $request->mouse_id
                ]);

                $jumlah =  Sparepart::where('id', $request->mouse_id)->value('jumlah') - 1;
                Sparepart::where('id', $request->mouse_id)->update([
                    'jumlah' => $jumlah
                ]);

                $sparepart = Sparepart::where([
                    ['kategori', 'mouse'],
                    ['merek', $perangkat->mouse_merek],
                    ['is_baru', false],
                ])->first();

                if ($sparepart) {
                    Sparepart::where('id', $sparepart->id)->update([
                        'jumlah' => $sparepart->jumlah + 1,
                    ]);
                } else {
                    Sparepart::create([
                        'kategori' => 'mouse',
                        'merek' => $perangkat->mouse_merek,
                        'jumlah' => 1,
                    ]);
                }
            }
        }

        if (!$perbaikan) {
            alert()->error('Error', 'Gagal menambahkan Perbaikan!');
            return back();
        }

        alert()->success('Success', 'Berhasil menambahkan Perbaikan');

        return redirect('admin/perbaikan');
    }

    public function perangkat_search(Request $request)
    {
        $keyword = $request->keyword;

        $perangkats = Perangkat::whereHas('karyawan', function ($query) use ($keyword) {
            $query->where('nama', 'like', "%$keyword%");
        })->orWhereHas('unit', function ($query) use ($keyword) {
            $query->where('nama', 'like', "%$keyword%");
        })
            ->select('id', 'karyawan_id', 'unit_id')
            ->with('karyawan:id,nama')
            ->with('unit:id,nama')
            ->take(10)
            ->get();

        return $perangkats;
    }

    public function perangkat_set($id)
    {
        $perangkat = Perangkat::where('id', $id)
            ->with('karyawan:id,nama')
            ->with('unit:id,nama')
            ->first();

        return $perangkat;
    }

    public function motherboard_set($id)
    {
        $motherboard = Sparepart::where([
            ['kategori', 'motherboard'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
                'model',
                'tipe',
            )
            ->first();

        return $motherboard;
    }

    public function prosesor_set($id)
    {
        $prosesor = Sparepart::where([
            ['kategori', 'prosesor'],
            ['id', $id],
        ])
            ->select(
                'id',
                'model',
            )
            ->first();

        return $prosesor;
    }

    public function ram_set($id)
    {
        $ram = Sparepart::where([
            ['kategori', 'ram'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
                'tipe',
                'kapasitas',
            )
            ->first();

        return $ram;
    }

    public function storage_set($id)
    {
        $storage = Sparepart::where([
            ['kategori', 'storage'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
                'tipe',
                'kapasitas',
            )
            ->first();

        return $storage;
    }

    public function psu_set($id)
    {
        $psu = Sparepart::where([
            ['kategori', 'psu'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
                'kapasitas',
            )
            ->first();

        return $psu;
    }

    public function heatsink_set($id)
    {
        $heatsink = Sparepart::where([
            ['kategori', 'heatsink'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
                'model',
            )
            ->first();

        return $heatsink;
    }

    public function monitor_set($id)
    {
        $monitor = Sparepart::where([
            ['kategori', 'monitor'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
                'kapasitas',
            )
            ->first();

        return $monitor;
    }

    public function keyboard_set($id)
    {
        $keyboard = Sparepart::where([
            ['kategori', 'keyboard'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
            )
            ->first();

        return $keyboard;
    }

    public function mouse_set($id)
    {
        $mouse = Sparepart::where([
            ['kategori', 'mouse'],
            ['id', $id],
        ])
            ->select(
                'id',
                'merek',
            )
            ->first();

        return $mouse;
    }
}
