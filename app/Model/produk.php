<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Model\transaksi;
class produk extends Model
{
    protected $table = 'produk';

    public static function getproduk($embarkasi){
        $start_date = date('Y-m-d');
        return self::whereDate('tanggal_keberangkatan', '>=', $start_date)
        ->where('kode_embarkasi', $embarkasi)
        ->where('status', 'Y')
        ->get();
    }

    public static function countProdukSoldOut($kode_produk)
    {
        $produk = transaksi::where('kode_produk', $kode_produk)
        ->where('status', 'approved')
        ->get();

        return count($produk);
    }

    public static function getonedata($kode_produk, $field){
        return self::select($field)->where('kode_produk',$kode_produk)->first()->$field;
    }

    public static function getonerow($kode_produk, $field){
        return self::select($field)->where('kode_produk',$kode_produk)->first();
    }
}
