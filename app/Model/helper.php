<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class helper extends Model
{
    public static function replacedate($tgl){
        return str_replace(['-',' ',':'],'',$tgl);
    }
}
