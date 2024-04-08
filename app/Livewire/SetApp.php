<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SetApp extends Component
{
    use WithFileUploads;
    public $app_name, $alamat, $no_hp, $image, $logo, $size, $primaryColor;

    public function mount(){
        $name = Setting::where('name','app_name')->first();
        if($name){
            $this->app_name = $name->data;
        }
        $alamat = Setting::where('name','alamat')->first();
        if($alamat){
            $this->alamat = $alamat->data;
        }
        $no_hp = Setting::where('name','no_hp')->first();
        if($no_hp){
            $this->no_hp = $no_hp->data;
        }
        $logo = Setting::where('name','logo')->first();
        if($logo){
            $this->logo = json_decode($logo->data);
            $this->size = $this->logo->size;
        }
    }

    protected $messages = [
        'size.required' => 'Ukuran logo harus diisi !',
        'size.integer' => 'Harus diisi dengan angka !',
        'app_name.required' => 'Nama aplikasi harus diisi !',
        'alamat.required' => 'Alamat harus diisi !',
        'no_hp.required' => 'Nomor hp harus diisi !'
    ];

    public function updatedImage(){
        $this->logo = null;
    }

    public function update(){
        $this->validate([
            'app_name' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'size' => 'required|integer'
        ]);

        $file = Setting::where('name','logo')->first();
        
        $this->logo =[
            'size' => $this->size
        ];
        

        if($this->image){
            if($file){
                $decode = json_decode($file->data);
                $deletedFile = Storage::delete($decode->path);
            }
            $path = $this->image->store('images');
            $this->logo['path'] = $path;
        }else{
            if($file){
                $decode = json_decode($file->data);
                $this->logo['path'] = $decode->path;
            }
        }


        DB::transaction(function () {
            Setting::updateOrCreate([
                'name' => 'app_name'
            ],[
                'data' => $this->app_name
            ]);

            Setting::updateOrCreate([
                'name' => 'alamat'
            ],[
                'data' => $this->alamat
            ]);

            Setting::updateOrCreate([
                'name' => 'no_hp'
            ],[
                'data' => $this->no_hp
            ]);

            Setting::updateOrCreate([
                'name' => 'logo'
            ],[
                'data' => json_encode($this->logo)
            ]);
        });

        $file = Setting::where('name','logo')->first();
        $this->logo = json_decode($file->data);

        $this->dispatch('show-alert');
    }
    public function render()
    {
        return view('livewire.set-app');
    }
}