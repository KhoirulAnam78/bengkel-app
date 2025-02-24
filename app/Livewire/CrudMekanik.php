<?php
namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CrudMekanik extends Component
{
    public $name, $no_telp, $alamat;
    public $proses_id;

    public function rules()
    {
        if ($this->proses_id) {
            return [
                'name' => 'required',
            ];
        }
        return [
            'name' => 'required|unique:mekanik,name',
        ];

    }

    protected $messages = [
        'name.required' => 'Nama mekanik wajib diisi !',
        'name.unique' => 'Mekanik sudah ada !',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function empty()
    {
        $this->name = null;
        $this->no_telp = null;
        $this->alamat = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        DB::table('mekanik')->insert([
            'name' => $this->name,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
        ]);
        $this->empty();

        $this->dispatch('close-modal', ['info' => 'Berhasil', 'message' => 'Berhasil menambahkan data!']);

        $this->dispatch('update-datatable');
    }

    public function show($id)
    {
        $this->proses_id = $id;
        $data = DB::table('mekanik')->find($id);
        $this->name = $data->name;
        $this->no_telp = $data->no_telp;
        $this->alamat = $data->alamat;
        $this->dispatch('show-modal-edit');
    }

    public function update()
    {
        $this->validate();
        DB::table('mekanik')->where('id', $this->proses_id)->update([
            'name' => $this->name,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
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
            $data = DB::table('mekanik')->where('id', $this->proses_id)->update(['is_deleted' => 1]);
            $this->dispatch('close-delete-modal', ['info' => 'Berhasil', 'message' => 'Berhasil menghapus data!']);
        } catch (\Throwable $th) {
            $this->dispatch('close-delete-modal', ['info' => 'Gagal', 'message' => 'Gagal menghapus data, data digunakan sebagai referensi dalam aplikasi!']);
        }
        $this->dispatch('update-datatable');
        $this->proses_id = null;
    }

    public function render()
    {
        return view('livewire.crud-mekanik');
    }
}
