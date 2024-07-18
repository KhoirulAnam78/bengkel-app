<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Sparepart::query();
            
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('price', function($data){
                $html = '<span>Harga Modal : <strong>Rp.'.$data->buying_price.'</strong>  <br> Harga Jual : <strong>Rp.'.$data->selling_price.'</strong></span>';
                return $html;
            })
            ->addColumn('aksi',function ($data){
                return '<span class="btn btn-info btn-sm mb-2" wire:click="show('.$data->id.')">Edit</span> <span class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</span>';
            })
            ->rawColumns(['aksi','price'])
            ->make(true);
        }
        $title = 'Data Master Spareparts';
        return view('master-data.spareparts', compact('title'));
    }
}