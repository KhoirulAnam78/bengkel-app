<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{
    public function transaksi()
    {
        $title = 'Transaksi Bengkel';
        return view('transaksi.transaksi-bengkel', compact('title'));
    }

    public function riwayat(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('transaksi as a')
                ->where('jenis_transaksi', 'keluar')
                ->when(!$request->get('order')[0]['column'], function ($q) {
                    $q->orderBy('a.tgl_transaksi', 'DESC');
                });
            return DataTables::of($query)
                ->addColumn('nama_pelanggan', function ($data) {
                    return $data->nama_pelanggan ?? '-';
                })
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    $html = '<a href="' . route('transaksi.cetak', ['id' => Crypt::encrypt($data->id)]) . '" target="_blank" class="btn btn-info btn-sm mb-2" >Cetak</a> ';

                    // if(auth()->user()->hasRole(1)){
                    //     $html .= '<a href="#" class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</a>';
                    // }

                    return $html;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        $title = "Riwayat Transaksi Bengkel";
        return view('transaksi.riwayat-transaksi', compact('title'));
    }

    public function cetak($id)
    {
        $decrypt = Crypt::decrypt($id);
        $transaksi = DB::table('transaksi')->where('id', $decrypt)->first();
        $detailTrans = DB::table('detail_transaksi')->where('id_transaksi', $decrypt)->get();
        $name = Setting::where('name', 'app_name')->first();
        $app_name = "";
        if ($name) {
            $app_name = $name->data;
        }

        $data = Setting::where('name', 'no_hp')->first();
        $no_hp = "";
        if ($data) {
            $no_hp = $data->data;
        }

        $data = Setting::where('name', 'alamat')->first();
        $alamat = "";
        if ($data) {
            $alamat = $data->data;
        }

        $logo = Setting::where('name', 'logo')->first();
        $app_logo = null;
        if ($logo) {
            $app_logo = json_decode($logo->data);
        }

        return view('transaksi.cetak-transaksi', compact('transaksi', 'detailTrans', 'alamat', 'app_name', 'no_hp', 'app_logo'));
    }
}
