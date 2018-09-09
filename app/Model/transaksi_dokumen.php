<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class transaksi_dokumen extends Model
{
    protected $table = 'transaksi_dokumen';

    public static function cektransaksi($nomor_transaksi){
        return self::select('nomor_transaksi', 'id')->where('nomor_transaksi',$nomor_transaksi)
            ->first();
    }
}
