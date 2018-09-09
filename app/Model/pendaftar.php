<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pendaftar extends Model
{
    protected $table = 'pendaftar';

    public static function ceknoreff($noreff){
        return self::select('nomor_pendaftar')->where('nomor_pendaftar',$noreff)->first();
    }

    public static function getpendaftarbyperusahaan($kode_perusahaan, $approval=null){

        if ($approval == null){
            return self::where('kode_perusahaan',$kode_perusahaan)->paginate(10);
        }else{
            return self::where('kode_perusahaan',$kode_perusahaan)->where('status',$approval)->paginate(10);
        }
    }
}
