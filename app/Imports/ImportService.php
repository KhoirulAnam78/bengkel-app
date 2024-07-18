<?php

namespace App\Imports;

use App\Models\Service;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportService implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Service::updateOrCreate([
                'code' => $row['kode'],
            ],[
                'name' => $row['nama'],
                'price' => $row['harga'],
                'descriptions' => $row['keterangan']
            ]);
        }
    }
}