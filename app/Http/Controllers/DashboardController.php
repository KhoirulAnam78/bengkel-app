<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $transaksi_hari_ini = DB::table('transaksi')->whereDate('tgl_transaksi', date('Y-m-d'))
            ->where('jenis_transaksi', 'keluar')->count();
        $penghasilan = DB::table('transaksi')->whereDate('tgl_transaksi', date('Y-m-d'))
            ->where('jenis_transaksi', 'keluar')->sum('total');

        $pengeluaran_hari_ini = DB::table('transaksi')->whereDate('tgl_transaksi', date('Y-m-d'))
            ->where('jenis_transaksi', 'masuk')->count();
        $pengeluaran = DB::table('transaksi')->whereDate('tgl_transaksi', date('Y-m-d'))
            ->where('jenis_transaksi', 'masuk')->sum('total');

        return view('dashboard.index', compact('user', 'transaksi_hari_ini', 'penghasilan', 'pengeluaran_hari_ini', 'pengeluaran'));
    }

    public function mode()
    {
        if (!session()->has('mode')) {
            session()->put('mode', 'dark');
        } else {
            if (session()->get('mode') == 'light') {
                session()->put('mode', 'dark');
            } else {
                session()->put('mode', 'light');
            }
        }
        return redirect()->back();

    }
}
