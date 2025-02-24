<?php
namespace App\Exports;

use App\Models\Sparepart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportSparepart implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Sparepart::where('spareparts.is_deleted', 0)
            ->join('jenis_motor as b', 'b.id', 'spareparts.id_jenis')
            ->select('spareparts.*', 'b.code as kode_motor')->get();
    }

    public function map($data): array
    {
        return [
            $data->code,
            $data->name,
            $data->satuan,
            $data->buying_price,
            $data->selling_price,
            $data->reseller_price,
            $data->kode_motor,
            $data->stok,
            $data->descriptions,
        ];
    }

    public function headings(): array
    {
        return [
            'kode',
            'nama',
            'satuan',
            'harga_beli',
            'harga_jual',
            'harga_reseller',
            'kode_motor',
            'stok',
            'keterangan',
        ];
    }
}
