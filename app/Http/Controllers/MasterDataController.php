<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    public function sparepart(Request $request)
    {
        if($request->ajax()){
            $query = DB::table('spareparts as a')
            ->leftjoin('jenis_motor as b','b.id','a.id_jenis')
            ->when(!$request->get('order')[0]['column'], function($q){
                $q->orderBy('a.code');
            })
            ->select('a.*','b.name as nama_jenis_motor');
            
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name',function($data){
                $html = $data->name;
                if($data->nama_jenis_motor){
                    $html .= '<br><span class="badge bg-primary">'.$data->nama_jenis_motor.'</span>';
                }
                return $html;
            })
            ->addColumn('price', function($data){
                $html = '<span>Beli : <strong>Rp.'.$data->buying_price.'</strong>  <br> Jual : <strong>Rp.'.$data->selling_price.'</strong></span>';
                return $html;
            })
            ->addColumn('aksi',function ($data){
                return '<span class="btn btn-info btn-sm mb-2" wire:click="show('.$data->id.')">Edit</span> <span class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</span>';
            })
            ->rawColumns(['aksi','price','name'])
            ->make(true);
        }
        $title = 'Data Master Spareparts';
        return view('master-data.spareparts', compact('title'));
    }
    public function services(Request $request)
    {
        if($request->ajax()){
            $query = DB::table('services as a')
            ->when(!$request->get('order')[0]['column'], function($q){
                $q->orderBy('code');
            })
            ->select('a.*');
            
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi',function ($data){
                return '<span class="btn btn-info btn-sm mb-2" wire:click="show('.$data->id.')">Edit</span> <span class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</span>';
            })
            ->rawColumns(['aksi','price'])
            ->make(true);
        }
        $title = 'Data Master Services';
        return view('master-data.services', compact('title'));
    }

    public function jenisMotor(Request $request)
    {
        if($request->ajax()){
            $query = DB::table('jenis_motor as a')
            ->when(!$request->get('order')[0]['column'], function($q){
                $q->orderBy('code');
            });
            
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi',function ($data){
                return '<span class="btn btn-info btn-sm mb-2" wire:click="show('.$data->id.')">Edit</span> <span class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</span>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        $title = 'Data Master Jenis Motor';
        return view('master-data.jenis-motor', compact('title'));
    }

    public function mekanik(Request $request)
    {
        if($request->ajax()){
            $query = DB::table('mekanik as a')
            ->when(!$request->get('order')[0]['column'], function($q){
                $q->orderBy('name');
            });
            
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi',function ($data){
                return '<span class="btn btn-info btn-sm mb-2" wire:click="show('.$data->id.')">Edit</span> <span class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</span>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        $title = 'Data Master Montir/Mekanik';
        return view('master-data.mekanik', compact('title'));
    }

    public function suppliers(Request $request)
    {
        if($request->ajax()){
            $query = DB::table('suppliers as a')
            ->when(!$request->get('order')[0]['column'], function($q){
                $q->orderBy('name');
            });
            
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi',function ($data){
                return '<span class="btn btn-info btn-sm mb-2" wire:click="show('.$data->id.')">Edit</span> <span class="btn btn-danger btn-sm mb-2" wire:click="showDelete('.$data->id.')">Delete</span>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        $title = 'Data Master Suppliers';
        return view('master-data.suppliers', compact('title'));
    }
}