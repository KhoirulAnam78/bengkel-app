<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Helper\GlobalHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class CrudTransaksiBengkel extends Component
{
    public $no_transaksi, $tgl_transaksi, $nama_pelanggan, $keterangan;
    public $kode_sparepart, $nama_sparepart, $selling_price, $jumlah, $stok;
    public $kode_service,$nama_service, $harga_service, $diskon, $mekanik;

    public $transaksi_temp = [], $total, $jml_bayar, $kembalian;
    public $proses_id=0;

    public function mount(){
        // $trans = DB::table('transaksi')->select('id')->orderBy('created_at','DESC')->first();
        // if($trans){
        //     $this->no_transaksi= 'IJM-TRANS-000000000000000'. $trans->id + 1;
        // }else{
        //     $this->no_transaksi= 'IJM-TRANS-000000000000000'.'1';
        // }

        $this->no_transaksi = GlobalHelper::generateInvoiceNumber('keluar');
        // dd($this->no_transaksi);
        // $this->no_transaksi = $id;
    }
    public function rules(){

        $validations =  [
            'no_transaksi' => 'required|unique:transaksi,no_transaksi',
            'tgl_transaksi' => 'required',
            'nama_pelanggan' => 'required',
            'keterangan' => 'nullable',
        ];

        if($this->kode_sparepart){
            $validations['kode_sparepart'] = 'required';
            $validations['selling_price'] = 'required';
            $validations['jumlah'] = 'required';
        }
        
        if($this->kode_service){
            $validations['kode_service'] = 'required';
            $validations['harga_service'] = 'required';
            $validations['mekanik'] ='required';
        }
    }

    protected $messages = [
        'no_transaksi.required' => 'Nomor transaksi tidak boleh kosong !',
        'no_transaksi.unique' => 'Nomor transaksi sudah digunakan !',
        'tgl_transaksi.required' => 'Tanggal transaksi tidak boleh kosong !',
        'nama_pelanggan.required' => 'Nama pelanggan tidak boleh kosong !',
        'kode_sparepart.required' => 'Sparepart tidak boleh kosong !',
        'selling_price.required' => 'Harga jual tidak boleh kosong !',
        'jumlah.required' => 'Jumlah tidak boleh kosong !',
        'kode_service.required' => 'Jasa service tidak boleh kosong !',
        'harga_service.required' => 'Harga service tidak boleh kosong !',
        'mekanik.required' => 'Mekanik tidak boleh kosong !',
        'transaksi_temp.required' => 'Harus ada minimal satu transaksi !'
    ];

    public function updatedKodeSparepart(){
        $sparepart = DB::table('spareparts')->where('code',$this->kode_sparepart)->first();
        if($sparepart){
            $this->selling_price = $sparepart->selling_price;
            $this->nama_sparepart = $sparepart->name;
            $this->stok = $sparepart->stok;
        }
    }

    public function tambahSparepart(){
        $this->validate([
            'kode_sparepart' => 'required',
            'selling_price' => 'required',
            'jumlah' => 'required'
        ]);

        $subtotal = (int)$this->jumlah * $this->selling_price;
        $this->transaksi_temp[] = [
            'jenis' => 'sparepart',
            'kode' => $this->kode_sparepart,
            'nama' => $this->nama_sparepart,
            'harga' => $this->selling_price,
            'jumlah' => $this->jumlah,
            'mekanik' => null,
            'sub_total' => $subtotal,
            'keterangan' => '-'
        ];
        $this->total = $this->total + $subtotal;
        $this->updatedJmlBayar();
        $this->kode_sparepart = null;
        $this->selling_price = null;
        $this->jumlah = null;
        $this->stok = null;
        $this->dispatch('empty-sparepart-form');
    }

    public function empty(){
        $this->kode_sparepart = null;
        $this->selling_price = null;
        $this->jumlah = null;
        $this->stok = null;
        $this->kode_service = null;
        $this->mekanik = null;
        $this->harga_service = null;
    }

    public function updatedKodeService(){
        $service = DB::table('services')->where('code',$this->kode_service)->first();
        if($service){
            $this->harga_service = $service->price;
            $this->nama_service = $service->name;
        }
    }
    
    public function tambahService(){
        $this->validate([
            'kode_service' => 'required',
            'harga_service' => 'required',
            'mekanik' => 'required'
        ]);
        
        $mekanik = DB::table('mekanik')->where('id',$this->mekanik)->first();

        $this->transaksi_temp[] = [
            'jenis' => 'service',
            'kode' => $this->kode_service,
            'nama' => $this->nama_service,
            'harga' => $this->harga_service,
            'jumlah' => 1,
            'mekanik' => $this->mekanik,
            'sub_total' => $this->harga_service,
            'keterangan' => 'Mekanik : '.$mekanik->name
        ];

        $this->total = $this->total + $this->harga_service;
        $this->updatedJmlBayar();
        $this->kode_service = null;
        $this->mekanik = null;
        $this->harga_service = null;
        $this->dispatch('empty-service-form');
    }

    public function proses(){
        $this->validate([
            'no_transaksi' => 'required|unique:transaksi,no_transaksi',
            'tgl_transaksi' => 'required',
            'nama_pelanggan' => 'required',
            'keterangan' => 'nullable',
            'transaksi_temp' => 'required'
        ]);
        
        DB::transaction(function () {
            $tgl = date('H:i:s');
            // INPUT TRANSACTION
            $transaksi = Transaksi::create([
                'no_transaksi' => $this->no_transaksi,
                'tgl_transaksi' => $this->tgl_transaksi.' '.$tgl,
                'nama_pelanggan' => $this->nama_pelanggan,
                'keterangan' => $this->keterangan,
                'total' => $this->total,
                'jenis_transaksi' => 'keluar',
                'bayar' => $this->jml_bayar,
                'kembalian' => $this->kembalian
            ]);
            $this->proses_id = Crypt::encrypt($transaksi->id);
            
            foreach($this->transaksi_temp as $value){
                DB::table('detail_transaksi')->insert([
                    'id_transaksi' => $transaksi->id,
                    'jenis' => $value['jenis'],
                    'code' => $value['kode'],
                    'name' => $value['nama'],
                    'harga' => $value['harga'],
                    'jumlah' => $value['jumlah'],
                    'sub_total' => $value['sub_total'],
                    'id_mekanik' => $this->mekanik
                ]);

                if($value['jenis']=='sparepart'){
                    $data = DB::table('spareparts')->where('code',$value['kode'])->first();
                    $stok = $data->stok - $value['jumlah'];
                    DB::table('spareparts')->where('code',$value['kode'])->update([
                        'stok' => $stok
                    ]);
                }
            }
            
            $this->dispatch('show-alert');
        });
    }

    public function deleteTemp($key){
        $transaksi = $this->transaksi_temp[$key];
        $this->total = $this->total - $transaksi['sub_total'];
        unset($this->transaksi_temp[$key]);
        $this->updatedJmlBayar();
    }

    public function updatedJmlBayar(){
        if($this->jml_bayar){
            $this->kembalian = $this->jml_bayar - $this->total;
        }
    }
    
    public function render()
    {
        return view('livewire.crud-transaksi-bengkel');
    }
}