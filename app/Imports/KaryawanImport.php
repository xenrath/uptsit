<?php

namespace App\Imports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KaryawanImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        return new Karyawan([
            'nama' => $row['nama'],
            'telp' => $row['telp'],
            'unit_id' => $row['unit_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            '*.nama' => 'required',
            'telp' => 'required|unique:karyawans',
            '*.telp' => 'required|unique:karyawans',
            'unit_id' => 'required',
            '*.unit_id' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Nama harus diisi!',
            'telp.required' => 'Nomor Telepon diisi!',
            'telp.unique' => 'Nomor Telepon sudah digunakan!',
            'unit_id.required' => 'Prodi ID harus diisi!',
        ];
    }
}
