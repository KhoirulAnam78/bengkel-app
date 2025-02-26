<?php
namespace App\Helper;

use App\Models\Transaksi;
use DateTime;

class GlobalHelper
{

    public static function generateInvoiceNumber($jenis): string
    {

        try {

            $current_date_time = new DateTime();
            $date_sequence = $current_date_time->format("dmy");

// Ambil transaksi terakhir berdasarkan jenis transaksi dan tanggal
            $lastTransactionId = Transaksi::orderBy('no_transaksi', 'desc')
                ->whereYear('tgl_transaksi', date('Y'))
                ->whereMonth('tgl_transaksi', date('m'))
                ->where('jenis_transaksi', $jenis)
                ->first();

            if (!$lastTransactionId) {
                $number = 1; // Mulai dari 1 jika belum ada transaksi
            } else {
                $lastNumber = intval(substr($lastTransactionId->no_transaksi, -3)); // Ambil 3 digit terakhir
                $number = $lastNumber + 1; // Lanjutkan nomor terakhir
            }

// Tentukan prefix berdasarkan jenis transaksi
            $prefix = ($jenis == 'keluar') ? "IJM-" : "RES-";

// Buat kode transaksi baru
            return $prefix . $date_sequence . sprintf('%03d', $number);

        } catch (\Exception $e) {
            dd($e);
        }

    }
}
