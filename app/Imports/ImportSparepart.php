<?php
namespace App\Imports;

use App\Models\Sparepart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSparepart implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $jenis = DB::table('jenis_motor')->where('code', $row['kode_motor'])->first();

            $test = Sparepart::updateOrCreate([
                'code' => $row['kode'],
            ], [
                'name' => $row['nama'],
                'satuan' => $row['satuan'],
                'buying_price' => $row['harga_beli'],
                'selling_price' => $row['harga_jual'],
                'reseller_price' => $row['harga_reseller'],
                'descriptions' => $row['keterangan'],
                'id_jenis' => $jenis->id,
                'stok' => $row['stok'],
            ]);
        }
    }
}
