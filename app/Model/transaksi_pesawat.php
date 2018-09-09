<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class transaksi_pesawat extends Model
{
    protected $table = 'transaksi_pesawat';

    public static function insert($request)
    {
        $table = new self;
        $table->nomor_transaksi = $request->nomor_transaksi;
        $table->kode_kursi = $request->kode_kursi;
        $table->save();

        return $table;
    }
}
