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

            //section generate the sequence of running number of trip sheet

            $lastTransactionId = Transaksi::orderBy('no_transaksi', 'desc')->where('jenis_transaksi', $jenis)->first();

            if (!$lastTransactionId) {
                $number = 0;
            } else {
                $number = substr($lastTransactionId->no_transaksi, -1);
            }

            if ($jenis == 'keluar') {
                return "IJM-" . $date_sequence . sprintf('%03d', intval($number) + 1);
            } else {
                return "RES-" . $date_sequence . sprintf('%03d', intval($number) + 1);
            }

        } catch (\Exception $e) {
            dd($e);
        }

    }
}
