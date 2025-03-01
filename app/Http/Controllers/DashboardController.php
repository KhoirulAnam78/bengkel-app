<?php
namespace App\Http\Controllers;

use App\Helper\GlobalHelper;
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

        $bulan = GlobalHelper::bulan();
        $tahun = date('Y');
        $chartPemasukan = [];
        $chartPengeluaran = [];
        foreach ($bulan as $key => $b) {
            $chartPemasukan['x'][] = $b;
            $jml = DB::table('transaksi')
                ->whereMonth('tgl_transaksi', $key)
                ->whereYear('tgl_transaksi', $tahun)
                ->where('jenis_transaksi', 'keluar')->count();
            $hepeng = DB::table('transaksi')
                ->whereMonth('tgl_transaksi', $key)
                ->whereYear('tgl_transaksi', $tahun)
                ->where('jenis_transaksi', 'keluar')->sum('total');

            $chartPemasukan['y'][] = (int) $jml;
            $chartPemasukan['z'][] = (int) $hepeng;

            $chartPengeluaran['x'][] = $b;
            $jml2 = DB::table('transaksi')
                ->whereMonth('tgl_transaksi', $key)
                ->whereYear('tgl_transaksi', $tahun)
                ->where('jenis_transaksi', 'masuk')->count();

            $hepeng2 = DB::table('transaksi')
                ->whereMonth('tgl_transaksi', $key)
                ->whereYear('tgl_transaksi', $tahun)
                ->where('jenis_transaksi', 'masuk')->sum('total');

            $chartPengeluaran['y'][] = (int) $jml2;

            $chartPengeluaran['z'][] = (int) $hepeng2;
        }
        return view('dashboard.index', compact('user', 'transaksi_hari_ini', 'penghasilan', 'pengeluaran_hari_ini', 'pengeluaran', 'chartPemasukan', 'chartPengeluaran'));
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
