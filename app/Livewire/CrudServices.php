<?php
namespace App\Livewire;

use App\Exports\ExportService;
use App\Imports\ImportService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CrudServices extends Component
{
    public $code, $name, $price, $descriptions;
    public $proses_id;
    public $file;

    use WithFileUploads;

    public function rules()
    {
        if ($this->proses_id) {
            return [
                'code' => 'required',
                'name' => 'required',
                'price' => 'required|integer',
            ];
        }
        return [
            'code' => 'required|unique:services,code',
            'name' => 'required',
            'price' => 'required|integer',
        ];

    }

    protected $messages = [
        'code.required' => 'Kode barang wajib diisi !',
        'code.unique' => 'Kode barang sudah dipakai untuk barang lain',
        'price.required' => 'Harga modal harus diisi !',
        'price.integer' => 'Harga modal harus berupa angka !',
        'name.required' => 'Nama sparepart wajib diisi !',
        'file.required' => 'Upload file excel terlebih dahulu !',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function empty()
    {
        $this->code = null;
        $this->name = null;
        $this->price = null;
        $this->descriptions = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv',
        ]);
        try {
            Excel::import(new ImportService(), $this->file);
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
            return Excel::download(new ExportService(), 'data-layanan-service.xlsx');
            $this->dispatch('alert', ['info' => 'Gagal', 'message' => 'Berhasil mengexport data !']);
        } catch (\Throwable $th) {
            $this->dispatch('alert', ['info' => 'Gagal', 'message' => 'Gagal mengexport data !, ' . $th]);
        }

    }

    public function save()
    {
        $this->validate();
        DB::table('services')->insert([
            'code' => $this->code,
            'name' => $this->name,
            'price' => $this->price,
            'descriptions' => $this->descriptions,
        ]);
        $this->empty();

        $this->dispatch('close-modal', ['info' => 'Berhasil', 'message' => 'Berhasil menambahkan data!']);

        $this->dispatch('update-datatable');
    }

    public function show($id)
    {
        $this->proses_id = $id;
        $data = DB::table('services')->find($id);
        $this->code = $data->code;
        $this->price = $data->price;
        $this->name = $data->name;
        $this->descriptions = $data->descriptions;
        $this->dispatch('show-modal-edit');
    }

    public function update()
    {
        $this->validate();
        DB::table('services')->where('id', $this->proses_id)->update([
            'code' => $this->code,
            'name' => $this->name,
            'price' => $this->price,
            'descriptions' => $this->descriptions,
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
            $data = DB::table('services')->where('id', $this->proses_id)->update(['is_deleted' => 1]);
            $this->dispatch('close-delete-modal', ['info' => 'Berhasil', 'message' => 'Berhasil menghapus data!']);
        } catch (\Throwable $th) {
            $this->dispatch('close-delete-modal', ['info' => 'Gagal', 'message' => 'Gagal menghapus data, data digunakan sebagai referensi dalam aplikasi!']);
        }
        $this->dispatch('update-datatable');
        $this->proses_id = null;
    }

    public function render()
    {
        return view('livewire.crud-services');
    }
}
