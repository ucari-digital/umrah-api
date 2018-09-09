<?php

namespace App\Http\Controllers\v1;

use App\Model\dat_pesawat;
use App\Model\JsonStatus;
use App\Model\produk;
use App\Model\produk_harga;
use App\Model\produk_hotel;
use App\Model\produk_pesawat;
use App\Model\Validate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class ProdukController extends Controller
{
    public function getproduk(Request $request){
        if ($request->tgl) {
            $data = produk::where('tanggal_keberangkatan', $request->tgl)
            ->where('kode_embarkasi', $request->kode_embarkasi)
            ->first();
        } else {
            $produk = produk::getproduk($request->kode_embarkasi);
            $data = [];
            foreach($produk as $item){
                $count_produk = produk::countProdukSoldOut($item->kode_produk);
                // array_push($data, $count_produk);
                if($count_produk >= $item->seat){
                    $arr_data = [
                        'kode_produk' => $item->kode_produk,
                        'nama_produk' => $item->nama_produk,
                        'seat' => $item->seat,
                        'status' => $item->status,
                        'kode_embarkasi' => $item->kode_embarkasi,
                        'durasi_hotel_madinah' => $item->durasi_hotel_madinah,
                        'durasi_hotel_mekkah' => $item->durasi_hotel_mekkah,
                        'tanggal_kepulangan' => $item->tanggal_kepulangan,
                        'tanggal_keberangkatan' => $item->tanggal_keberangkatan,
                        'harga' => $item->harga,
                        'created_by' => $item->created_by,
                        'availabel' => false,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at
                    ];
                    array_push($data, $arr_data);
                } else {
                    $arr_data = [
                        'kode_produk' => $item->kode_produk,
                        'nama_produk' => $item->nama_produk,
                        'seat' => $item->seat,
                        'status' => $item->status,
                        'kode_embarkasi' => $item->kode_embarkasi,
                        'durasi_hotel_madinah' => $item->durasi_hotel_madinah,
                        'durasi_hotel_mekkah' => $item->durasi_hotel_mekkah,
                        'tanggal_kepulangan' => $item->tanggal_kepulangan,
                        'tanggal_keberangkatan' => $item->tanggal_keberangkatan,
                        'harga' => $item->harga,
                        'created_by' => $item->created_by,
                        'availabel' => true,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                    ];
                    array_push($data, $arr_data);
                }
            }

        }
        return JsonStatus::messagewithData(200,'berhasil',$data);
    }

    public function postproduk(Request $request){
        // dd(Carbon::now()->toDateString());
        DB::begintransaction();
        try{
            $validator = Validate::produk($request);

            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            $kode_produk = 'PRUMH'.str_replace('-','',$request->tanggal_keberangkatan).rand(100,999);
            $produk = new produk();
            $produk->kode_produk = $kode_produk;
            $produk->nama_produk = $request->nama_produk;
            $produk->seat = $request->seat;
            $produk->kode_pesawat = $request->kode_pesawat;
            $produk->kode_hotel_mekkah = $request->kode_hotel_mekkah;
            $produk->kode_hotel_madinah = $request->kode_hotel_madinah;
            $produk->tanggal_keberangkatan = $request->tanggal_keberangkatan;
            $produk->tanggal_kepulangan = $request->tanggal_kepulangan;
            $produk->harga = $request->harga;
            $produk->created_by = 'admin';
            $produk->save();


        }catch (\Exception $exception){
            DB::rollback();
            return JsonStatus::messageException($exception);
        }
        DB::commit();
        return JsonStatus::message(200,'berhasil di simpan');
    }

    public function produkDetail(Request $request)
    {
        try{
            $produk = produk::where('kode_produk', $request->kode_produk)->first();
            return Response::json($produk, 'Berhasil mengambil query', 'success', 200);
        } catch (\Exception $e) {
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }

    public function FunctionName($value='')
    {
        # code...
    }
}
