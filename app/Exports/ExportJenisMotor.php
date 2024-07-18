<?php

namespace App\Exports;

use App\Models\JenisMotor;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportJenisMotor implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JenisMotor::get();
    }
    
    public function map($data): array
    {
        return [
            $data->code,
            $data->name,
            $data->descriptions
        ];
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'Keterangan',
        ];
    }
}