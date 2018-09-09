<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Validate extends Model
{
    public static function pendaftar($request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required|max:16|min:16',
            'nip' => 'required',
            'jk' => 'required',
            'telephone' => 'required',
            'kode_perusahaan' => 'required',
        ]);

        return $validator;

    }

    public static function perusahaan($request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'slogan' => 'required',
            'logo' => 'required',
        ]);

        return $validator;
    }

    public static function perusahaanapproval($request){
        $validator = Validator::make($request->all(), [
            'nomor_pendaftar' => 'required',
            'status' => 'required',
        ]);

        return $validator;
    }

    public static function produk($request){
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'tanggal_keberangkatan' => 'required',
            'kode_pesawat' => 'required',
            'kode_hotel_madinah' => 'required',
            'kode_hotel_mekkah' => 'required',
            'tanggal_kepulangan' => 'required',
            'seat' => 'required',
            'harga' => 'required',
        ]);

        return $validator;
    }

    public static function transaksi($request){
        $validator = Validator::make($request->all(), [
            'kode_produk' => 'required',
            'nomor_peserta' => 'required',
        ]);

        return $validator;
    }

    public static function transaksi_pesawat($request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_peserta' => 'required',
            'kode_kursi' => 'required'
        ]);

        return $validator;
    }
    
    public static function dat_pesawat_seat($request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pesawat' => 'required',
            'kursi' => 'required'
        ]);

        return $validator;
    }
    
    public static function dat_pesawat($request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pesawat' => 'required'
        ]);

        return $validator;
    }

    public static function transaksidokumen($request){
        $validator = Validator::make($request->all(), [
            'nomor_peserta' => 'required'
        ]);

        return $validator;
    }


    public static function transaksihotel($request){
        $validator = Validator::make($request->all(), [
            'nomor_transaksi' => 'required',
            'kode_kamar' => 'required',
        ]);

        return $validator;
    }

    public static function addhotel($request){
        $validator = Validator::make($request->all(), [
            'nama_hotel' => 'required',
            'bintang' => 'required',
            'lokasi' => 'required',
        ]);

        return $validator;
    }

    public static function addkamar($request){
        $validator = Validator::make($request->all(), [
            'kode_hotel' => 'required',
            'nomor_kamar' => 'required',
            'lantai' => 'required',
            'tipe_kamar' => 'required',
        ]);

        return $validator;
    }

    public static function getkamar($request){
        $validator = Validator::make($request->all(), [
            'kode_hotel' => 'required',
        ]);

        return $validator;
    }

    public static function getkamaravaliabel($request){
        $validator = Validator::make($request->all(), [
            'kode_produk' => 'required',
        ]);

        return $validator;
    }

    public static function transaksipembayaran($request){
        $validator = Validator::make($request->all(), [
            'nomor_transaksi' => 'required',
            'jenis_pembayaran' => 'required',
            'bukti' => 'required',
            'jumlah_pembayaran' => 'required',
            'tgl_pembayaran' => 'required',
        ]);

        return $validator;
    }
}
