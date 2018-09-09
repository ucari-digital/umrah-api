<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table = 'transaksi';

    public static function gettransaksiuser($nomor_peserta){
        return self::where('nomor_peserta',$nomor_peserta)->paginate(10);
    }

    public static function cektransaksi($nomor_transaksi, $nomor_peserta){
        return self::where('nomor_transaksi',$nomor_transaksi)
            ->where('nomor_peserta', $nomor_peserta)
            ->first();
    }

    public static function countgroup($nomor_peserta){
        return self::where('no_reff',$nomor_peserta)->count();
    }
}
