<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Helper\GlobalHelper;
use Illuminate\Support\Facades\DB;

class RestockBarang extends Component
{
    public $no_transaksi, $tgl_transaksi, $supplier, $keterangan;
    public $kode_sparepart, $nama_sparepart, $buying_price, $jumlah, $stok;

    public $transaksi_temp = [], $total, $jml_bayar, $kembalian;

    public function mount(){
        // $trans = DB::table('transaksi')->select('id')->orderBy('created_at','DESC')->first();
        // if($trans){
        //     $this->no_transaksi= 'IJM-TRANS-000000000000000'. $trans->id + 1;
        // }else{
        //     $this->no_transaksi= 'IJM-TRANS-000000000000000'.'1';
        // }

        $this->no_transaksi = GlobalHelper::generateInvoiceNumber('masuk');
        // dd($this->no_transaksi);
        // $this->no_transaksi = $id;
    }
    public function rules(){

        $validations =  [
            'no_transaksi' => 'required|unique:transaksi,no_transaksi',
            'tgl_transaksi' => 'required',
            'supplier' => 'required',
            'keterangan' => 'nullable',
        ];

        if($this->kode_sparepart){
            $validations['kode_sparepart'] = 'required';
            $validations['buying_price'] = 'required';
            $validations['jumlah'] = 'required';
        }
        
    }

    protected $messages = [
        'no_transaksi.required' => 'Nomor transaksi tidak boleh kosong !',
        'no_transaksi.unique' => 'Nomor transaksi sudah digunakan !',
        'tgl_transaksi.required' => 'Tanggal transaksi tidak boleh kosong !',
        'supplier.required' => 'Supplier tidak boleh kosong !',
        'kode_sparepart.required' => 'Sparepart tidak boleh kosong !',
        'buying_price.required' => 'Harga jual tidak boleh kosong !',
        'jumlah.required' => 'Jumlah tidak boleh kosong !',
        'transaksi_temp.required' => 'Harus ada minimal satu transaksi !'
    ];

    public function updatedKodeSparepart(){
        $sparepart = DB::table('spareparts')->where('code',$this->kode_sparepart)->first();
        if($sparepart){
            $this->buying_price = $sparepart->buying_price;
            $this->nama_sparepart = $sparepart->name;
            $this->stok = $sparepart->stok;
        }
    }

    public function tambahSparepart(){
        $this->validate([
            'kode_sparepart' => 'required',
            'buying_price' => 'required',
            'jumlah' => 'required'
        ]);

        $subtotal = (int)$this->jumlah * $this->buying_price;
        $this->transaksi_temp[] = [
            'kode' => $this->kode_sparepart,
            'nama' => $this->nama_sparepart,
            'harga' => $this->buying_price,
            'jumlah' => $this->jumlah,
            'sub_total' => $subtotal,
        ];
        
        $this->total = $this->total + $subtotal;
        $this->updatedJmlBayar();
        $this->kode_sparepart = null;
        $this->buying_price = null;
        $this->jumlah = null;
        $this->stok = null;
        $this->dispatch('empty-sparepart-form');
    }

    public function proses(){
        $this->validate([
            'no_transaksi' => 'required|unique:transaksi,no_transaksi',
            'tgl_transaksi' => 'required',
            'supplier' => 'required',
            'keterangan' => 'nullable',
            'transaksi_temp' => 'required'
        ]);

        
        DB::transaction(function () {
            $tgl = date('H:i:s');
            $supplier = DB::table('suppliers')->where('id',$this->supplier)->first();
            // INPUT TRANSACTION
            $transaksi = Transaksi::create([
                'no_transaksi' => $this->no_transaksi,
                'tgl_transaksi' => $this->tgl_transaksi.' '.$tgl,
                'nama_pelanggan' => $supplier->name,
                'keterangan' => $this->keterangan,
                'jenis_transaksi' => 'masuk',
                'total' => $this->total,
                'bayar' => $this->jml_bayar,
                'kembalian' => $this->kembalian
            ]);
            
            foreach($this->transaksi_temp as $value){
                DB::table('detail_transaksi')->insert([
                    'id_transaksi' => $transaksi->id,
                    'jenis' => 'sparepart',
                    'code' => $value['kode'],
                    'name' => $value['nama'],
                    'harga' => $value['harga'],
                    'jumlah' => $value['jumlah'],
                    'sub_total' => $value['sub_total'],
                ]);

                $data = DB::table('spareparts')->where('code',$value['kode'])->first();
                $stok = $data->stok + $value['jumlah'];
                DB::table('spareparts')->where('code',$value['kode'])->update([
                    'stok' => $stok
                ]);
                
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
        return view('livewire.restock-barang');
    }
}