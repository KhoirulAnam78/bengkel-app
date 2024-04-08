<?php

namespace App\Helper;
use DateTime;
use App\Models\Transaksi;

class GlobalHelper  {
    
    static function generateInvoiceNumber($jenis):string
    {

       try{

        $current_date_time = new DateTime();

        $date_sequence = $current_date_time->format("dmy");

        //section generate the sequence of running number of trip sheet

        $lastTransactionId = Transaksi::orderBy('no_transaksi', 'desc')->where('jenis_transaksi',$jenis)->first();

        if (!$lastTransactionId)
            // We get here if there is no TripSheet at all
            // If there is no Trip sheet number set it to 0, which will be 1 at the end.
            $number = 0;
        else
            $number = substr($lastTransactionId->no_transaksi, 9);
        
        if($jenis == 'keluar'){
            return "IJM-".$date_sequence. sprintf('%03d', intval($number) + 1);
        }else{
            return "RES-".$date_sequence. sprintf('%03d', intval($number) + 1);
        }
            

       }
       catch (\Exception $e)
       {
           dd($e);
       }

    }
}
?>