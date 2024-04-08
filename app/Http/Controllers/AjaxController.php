<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function sparepart(){
        $data = DB::table('spareparts as a')
        ->where('a.name','like','%'.request('search').'%')
        ->orwhere('a.code','like','%'.request('search').'%')
        ->limit(20)
        ->get();
        
        $array = [];
        foreach ($data as $value) {
            $item = ['id' => $value->code, 'text' => '['.$value->code.'] '.$value->name];
            array_push($array,$item);
        }
        return $array;
    }

    public function service(){
        $data = DB::table('services as a')
        ->where('a.name','like','%'.request('search').'%')
        ->orwhere('a.code','like','%'.request('search').'%')
        ->limit(20)
        ->get();
        
        $array = [];
        foreach ($data as $value) {
            $item = ['id' => $value->code, 'text' => '['.$value->code.'] '.$value->name];
            array_push($array,$item);
        }
        return $array;
    }

    public function mekanik(){
        $data = DB::table('mekanik as a')
        ->where('a.name','like','%'.request('search').'%')
        ->limit(20)
        ->get();
        
        $array = [];
        foreach ($data as $value) {
            $item = ['id' => $value->id, 'text' => $value->name];
            array_push($array,$item);
        }
        return $array;
    }

    public function supplier(){
        $data = DB::table('suppliers as a')
        ->where('a.name','like','%'.request('search').'%')
        ->limit(20)
        ->get();
        
        $array = [];
        foreach ($data as $value) {
            $item = ['id' => $value->id, 'text' => $value->name];
            array_push($array,$item);
        }
        return $array;
    }
}