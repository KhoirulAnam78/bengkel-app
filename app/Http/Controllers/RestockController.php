<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class RestockController extends Controller
{
    public function index(){
        $title = "Restock Barang";
        return view('restock.index',compact('title'));
    }

    public function riwayat(Request $request){
        if($request->ajax()){
            $query = DB::table('transaksi as a')
            ->where('jenis_transaksi','masuk')
            ->when(!$request->get('order')[0]['column'], function($q){
                $q->orderBy('a.tgl_transaksi','DESC');
            });
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi',function ($data){
                $html = '<a href="'.route('transaksi.cetak',['id' => Crypt::encrypt($data->id)]).'" target="_blank" class="btn btn-info btn-sm mb-2" >Cetak</a> ';

                // if(auth()->user()->hasRole(1)){
                //     $html .= '<a href="#" class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</a>';
                // }

                return $html;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        $title = "Riwayat Restock Barang";
        return view('restock.riwayat-restock',compact('title'));
    }
}