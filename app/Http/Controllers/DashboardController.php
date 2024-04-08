<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.index',compact('user'));
    }

    public function mode(){
        if(!session()->has('mode')){
            session()->put('mode','dark');
        }else{
            if(session()->get('mode')=='light'){
                session()->put('mode','dark');
            }else{
                session()->put('mode','light');
            }
        }
        return redirect()->back();

    }
}