<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class dat_hotel extends Model
{
    protected $table = 'dat_hotel';

    public static function getonehotel($kode_hotel){
        return self::where('kode_hotel',$kode_hotel)->first();
    }

    public static function getdata(){
        return self::all();
    }
}
