<?php
namespace App\Livewire;

use App\Exports\ExportSparepart;
use App\Imports\ImportSparepart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CrudSpareparts extends Component
{
    public $code, $name, $satuan, $buying_price, $selling_price, $stok, $descriptions, $id_jenis, $reseller_price, $file;
    public $proses_id;
    use WithFileUploads;

    public function rules()
    {
        if ($this->proses_id) {
            return [
                'code' => 'required',
                'name' => 'required',
                'buying_price' => 'required|integer',
                'selling_price' => 'required|integer',
                'satuan' => 'required',
                'stok' => 'required|integer',
            ];
        }
        return [
            'code' => 'required|unique:spareparts,code',
            'name' => 'required',
            'buying_price' => 'required|integer',
            'selling_price' => 'required|integer',
            'satuan' => 'required',
            'stok' => 'required|integer',
        ];

    }

    protected $messages = [
        'code.required' => 'Kode barang wajib diisi !',
        'code.unique' => 'Kode barang sudah dipakai untuk barang lain',
        'buying_price.required' => 'Harga modal harus diisi !',
        'selling_price.required' => 'Harga jual harus diisi !',
        'buying_price.integer' => 'Harga modal harus berupa angka !',
        'selling_price.integer' => 'Harga jual harus berupa angka !',
        'name.required' => 'Nama sparepart wajib diisi !',
        'satuan.required' => 'Satuan barang wajib diisi !',
        'stok.required' => 'Stok wajib diisi !',
        'stok.integer' => 'Stok harus berupa angka !',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function empty()
    {
        $this->code = null;
        $this->name = null;
        $this->satuan = null;
        $this->buying_price = null;
        $this->selling_price = null;
        $this->reseller_price = null;
        $this->descriptions = null;
        $this->stok = null;
        $this->id_jenis = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        DB::table('spareparts')->insert([
            'code' => $this->code,
            'name' => $this->name,
            'satuan' => $this->satuan,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
            'stok' => $this->stok,
            'id_jenis' => $this->id_jenis,
            'descriptions' => $this->descriptions,
            'reseller_price' => $this->reseller_price,
        ]);
        $this->empty();

        $this->dispatch('close-modal', ['info' => 'Berhasil', 'message' => 'Berhasil menambahkan data!']);

        $this->dispatch('update-datatable');
    }

    public function show($id)
    {
        $this->proses_id = $id;
        $data = DB::table('spareparts')->find($id);
        $this->code = $data->code;
        $this->buying_price = $data->buying_price;
        $this->selling_price = $data->selling_price;
        $this->name = $data->name;
        $this->satuan = $data->satuan;
        $this->stok = $data->stok;
        $this->id_jenis = $data->id_jenis;
        $this->descriptions = $data->descriptions;
        $this->reseller_price = $this->reseller_price;
        $this->dispatch('show-modal-edit');
    }

    public function update()
    {
        $this->validate();
        if ($this->id_jenis == "") {
            $this->id_jenis = null;
        }

        DB::table('spareparts')->where('id', $this->proses_id)->update([
            'code' => $this->code,
            'name' => $this->name,
            'satuan' => $this->satuan,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
            'stok' => $this->stok,
            'id_jenis' => $this->id_jenis,
            'descriptions' => $this->descriptions,
            'reseller_price' => $this->reseller_price,
        ]);
        $this->dispatch('close-modal-edit', ['info' => 'Berhasil', 'message' => 'Berhasil mengubah data!']);
        $this->dispatch('update-datatable');
        $this->empty();
    }

    public function showDelete($id)
    {
        $this->proses_id = $id;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        try {
            $data = DB::table('spareparts')->where('id', $this->proses_id)->update(['is_deleted' => 1]);
            $this->dispatch('close-delete-modal', ['info' => 'Berhasil', 'message' => 'Berhasil menghapus data!']);
        } catch (\Throwable $th) {
            $this->dispatch('close-delete-modal', ['info' => 'Gagal', 'message' => 'Gagal menghapus data, data digunakan sebagai referensi dalam aplikasi!']);
        }
        $this->dispatch('update-datatable');
        $this->proses_id = null;
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv',
        ]);
        try {
            Excel::import(new ImportSparepart(), $this->file);
            //code...
            $this->dispatch('close-modal-import', ['info' => 'Berhasil', 'message' => 'Berhasil mengimport data!']);
            $this->dispatch('update-datatable');
        } catch (\Throwable $th) {
            $this->dispatch('close-modal-import', ['info' => 'Gagal', 'message' => 'Gagal mengimport data !, ' . $th]);
        }

    }

    public function export()
    {
        try {
            return Excel::download(new ExportSparepart(), 'data-sparepart.xlsx');
            $this->dispatch('alert', ['info' => 'Gagal', 'message' => 'Berhasil mengexport data !']);
        } catch (\Throwable $th) {
            $this->dispatch('alert', ['info' => 'Gagal', 'message' => 'Gagal mengexport data !, ' . $th]);
        }

    }

    public function render()
    {
        $jenisMotor = DB::table('jenis_motor')->get();
        return view('livewire.crud-spareparts', compact('jenisMotor'));
    }
}
