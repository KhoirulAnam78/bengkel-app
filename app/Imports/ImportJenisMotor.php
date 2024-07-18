<?php

namespace App\Imports;

use App\Models\JenisMotor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportJenisMotor implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            JenisMotor::updateOrCreate([
                'code' => $row['kode'],
            ],[
                'name' => $row['nama'],
                'descriptions' => $row['keterangan']
            ]);
        }
    }
}