<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportService implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Service::get();
    }
    
    public function map($data): array
    {
        return [
            $data->code,
            $data->name,
            $data->price,
            $data->descriptions
        ];
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'Harga',
            'Keterangan',
        ];
    }
}