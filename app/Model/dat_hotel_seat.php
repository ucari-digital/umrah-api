<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class dat_hotel_seat extends Model
{
    protected $table = 'dat_hotel_seat';

    public static function getdata($kode_hotel){
        return self::where('kode_hotel',$kode_hotel)->get();
    }
}
