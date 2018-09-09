<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class peserta extends Model
{
    protected $table = 'peserta';

    public static function getonerow($nomor_peserta, $field){
        return self::select($field)->where('nomor_peserta',$nomor_peserta)->first();
    }

    public static function getnomorpeserta($nomor_pendaftar){
        $cek = self::select('nomor_peserta')->where('nomor_pendaftar',$nomor_pendaftar)->first();
        if (!empty($cek)){
            return $cek->nomor_peserta;
        }else{
            return false;
        }

    }
}
