<?php

namespace App\Http\Controllers\v1;

use App\Model\dat_hotel;
use App\Model\dat_hotel_seat;
use App\Model\durasi_hotel;
use App\Model\JsonStatus;
use App\Model\peserta;
use App\Model\produk;
use App\Model\transaksi;
use App\Model\transaksi_hotel;
use App\Model\transaksi_hotel_mekkah;
use App\Model\Validate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helper\Response;
class HotelController extends Controller
{
    /**
     * Transaksi Hotel
     */

    public static function posttransaksihotel(Request $request){
        DB::begintransaction();
        try{

            $validator = Validate::transaksihotel($request);
            $peserta = peserta::getnomorpeserta($request->nomor_pendaftar);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            $cek = transaksi::cektransaksi($request->nomor_transaksi,$peserta);
            if (empty($cek)){
                return JsonStatus::message(401,'nomor transaksi tidak di temukan');
            }
            
            /**
             * mengecek apakah user udah booking hotel atau belum
             */
            if($request->hotel == 'madinah'){
                $cek_transaksi_hotel = transaksi_hotel::where('nomor_transaksi', $request->nomor_transaksi)
                ->where(['status' => 'approved', 'status' => 'approved'])
                ->first();
                
            } elseif($request->hotel == 'mekkah') {
                $cek_transaksi_hotel = transaksi_hotel_mekkah::where('nomor_transaksi', $request->nomor_transaksi)
                ->where(['status' => 'approved', 'status' => 'approved'])
                ->first();
            }

            $durasi = DB::table('transaksi')
            ->join('produk', 'transaksi.kode_produk', 'produk.kode_produk')
            ->select('transaksi.nomor_transaksi', 'produk.kode_produk', 'produk.durasi_hotel_madinah', 'produk.durasi_hotel_mekkah')
            ->where('transaksi.nomor_transaksi', $request->nomor_transaksi)
            ->first();

            /**
             * Membuat Durasi Hotel
             */
            if($request->hotel == 'madinah'){
                for ($i=0; $i <= 1; $i++) { 
                    $table = new durasi_hotel;
                    $table->nomor_transaksi = $durasi->nomor_transaksi;
                    $table->kode_produk = $durasi->kode_produk;
                    $table->kode_kamar = $request->kode_kamar;
                    $table->lokasi = 'madinah';
                    $table->tanggal = Carbon::createFromFormat('Y-m-d H:i:s', $durasi->durasi_hotel_madinah.' 00:00:00')->addDays($i);
                    $table->save();
                }
            }
            
            if($request->hotel == 'mekkah'){
                for ($i=0; $i <= 4; $i++) { 
                    $table = new durasi_hotel;
                    $table->nomor_transaksi = $durasi->nomor_transaksi;
                    $table->kode_produk = $durasi->kode_produk;
                    $table->kode_kamar = $request->kode_kamar;
                    $table->lokasi = 'mekkah';
                    $table->tanggal = Carbon::createFromFormat('Y-m-d H:i:s', $durasi->durasi_hotel_mekkah.' 00:00:00')->addDays($i);
                    $table->save();
                }
            }

            if($cek_transaksi_hotel){
                return Response::json(false, 'Sudah memilih hotel', 'success', 200);
            }


            $model = $request->except(['nomor_peserta', 'hotel']);
            $model['kode_produk'] = $cek->kode_produk;

            if($request->hotel == 'madinah'){
                transaksi_hotel::insert($model);
            } elseif($request->hotel == 'mekkah'){
                transaksi_hotel_mekkah::insert($model);
            }

        }catch (\Exception $exception){
            DB::rollback();
            return JsonStatus::messageException($exception);
        }
        DB::commit();
        return JsonStatus::message(200.,'berhasil di simpan');
    }

    public function addhotel(Request $request){
        DB::begintransaction();
        try {

            $validator = Validate::addhotel($request);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400, 'validasi', $validator->errors());
            }
            $model = $request->input();
            $model['kode_hotel'] = 'HTL'.rand(1000,9999);
            dat_hotel::insert($model);
        }catch (\Exception $exception){
            return JsonStatus::messageException($exception);
        }
        DB::commit();
        return JsonStatus::message(200,'berhasil di simpan');
    }

    public function addkamar(Request $request){
        DB::begintransaction();
        try {

            $validator = Validate::addkamar($request);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400, 'validasi', $validator->errors());
            }
            $cekkamar = dat_hotel::getonehotel($request->kode_hotel);
            if (empty($cekkamar)){
                return JsonStatus::message(401,'kode hotel tidak di temukan/kode hotel salah');
            }
            $model = $request->input();
            $model['kode_kamar'] = 'ROOM'.$request->kode_hotel.$request->lantai.$request->nomor_kamar;
            dat_hotel_seat::insert($model);
        }catch (\Exception $exception){
            return JsonStatus::messageException($exception);
        }
        DB::commit();
        return JsonStatus::message(200,'berhasil di simpan');
    }

    public function gethotel(Request $request){
        try{
            $data = dat_hotel::where('lokasi', $request->lokasi)->get();
            return JsonStatus::messagewithData(200,'data hotel', $data);
        }catch (\Exception $exception){
            return JsonStatus::messageException($exception);
        }
    }

    public function getkamar(Request $request){
        try{
            $validator = Validate::getkamar($request);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400, 'validasi', $validator->errors());
            }
            $cekkamar = dat_hotel::getonehotel($request->kode_hotel);
            if (empty($cekkamar)){
                return JsonStatus::message(401,'kode hotel tidak di temukan/kode hotel salah');
            }

            $data = dat_hotel_seat::getdata($request->kode_hotel);
            return JsonStatus::messagewithData(200,'data hotel', $data);
        }catch (\Exception $exception){
            return JsonStatus::messageException($exception);
        }
    }

    public function getKamarAvailabel(Request $request){
        try{
            $validator = Validate::getkamaravaliabel($request);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400, 'validasi', $validator->errors());
            }
            $produk = produk::where('kode_produk', $request->kode_produk)->first();

            /**
             * Mencompare hotel dengan mengammbil dari table durasi_hotel
             */
            $durasi_hotel_madinah = [];
            if($request->hotel == 'madinah'){
                $loop_madinah = [];
                for ($i=0; $i <= 1; $i++) { 
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $produk->durasi_hotel_madinah.' 00:00:00')->addDays($i);
                    array_push($loop_madinah, $carbon);
                }

                $first = true;
                $dump_durasi_hotel_madinah = [];
                foreach($loop_madinah as $loop){
                    $durasi = durasi_hotel::whereDate('tanggal', substr($loop, 0, 10))
                    ->where('lokasi', 'madinah')
                    ->get();
                }

                foreach($durasi as $item){
                    array_push($durasi_hotel_madinah, $item->kode_kamar);
                }
            }
            
            $durasi_hotel_mekkah = [];
            if($request->hotel == 'mekkah'){
                $loop_mekkah = [];
                for ($i=0; $i <= 4; $i++) { 
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $produk->durasi_hotel_mekkah.' 00:00:00')->addDays($i);
                    array_push($loop_mekkah, $carbon);
                }
                // return $loop_mekkah;
                $first = true;
                $dump_durasi_hotel_mekkah = [];
                foreach($loop_mekkah as $loop){
                    $durasi = durasi_hotel::whereDate('tanggal', substr($loop, 0, 10))
                    ->where('lokasi', 'mekkah')
                    ->get();
                }

                foreach($durasi as $item){
                    array_push($durasi_hotel_mekkah, $item->kode_kamar);
                }

            }

            /**
             * MADINAH HOTEL
             */

            $hotel_availabel_madinah = [];
            if ($request->hotel == 'madinah') {
                $hotel_avaialabel = DB::table('dat_hotel_seat')
                ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
                ->where('dat_hotel.lokasi', 'madinah')
                ->whereNotIn('dat_hotel_seat.kode_kamar', $durasi_hotel_madinah)
                ->where('dat_hotel.kode_hotel', $request->kode_hotel)
                ->where('dat_hotel_seat.lantai', $request->lantai)
                ->select('dat_hotel_seat.kode_hotel', 'dat_hotel_seat.kode_kamar', 'dat_hotel_seat.lantai', 'dat_hotel_seat.nomor_kamar', 'dat_hotel.nama_hotel')
                ->get();

                foreach ($hotel_avaialabel as $item) {
                    $arr = [
                        'kode_hotel' => $item->kode_hotel,
                        'kode_kamar' => $item->kode_kamar,
                        'lantai' => $item->lantai,
                        'nomor_kamar' => $item->nomor_kamar,
                        'nama_hotel' => $item->nama_hotel,
                        'status' => true
                    ];
                    array_push($hotel_availabel_madinah, $arr);
                }

                $hotel_not_avaialabel = DB::table('dat_hotel_seat')
                ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
                ->where('dat_hotel.lokasi', 'madinah')
                ->whereIn('dat_hotel_seat.kode_kamar', $durasi_hotel_madinah)
                ->where('dat_hotel.kode_hotel', $request->kode_hotel)
                ->where('dat_hotel_seat.lantai', $request->lantai)
                ->select('dat_hotel_seat.kode_hotel', 'dat_hotel_seat.kode_kamar', 'dat_hotel_seat.lantai', 'dat_hotel_seat.nomor_kamar', 'dat_hotel.nama_hotel')
                ->get();

                foreach ($hotel_not_avaialabel as $item) {
                    $arr = [
                        'kode_hotel' => $item->kode_hotel,
                        'kode_kamar' => $item->kode_kamar,
                        'lantai' => $item->lantai,
                        'nomor_kamar' => $item->nomor_kamar,
                        'nama_hotel' => $item->nama_hotel,
                        'status' => false
                    ];
                    array_push($hotel_availabel_madinah, $arr);
                }

                return $hotel_availabel_madinah;
            }

            /**
             * MEKKAH HOTEL
             */
            $hotel_availabel_mekkah = [];
            if ($request->hotel == 'mekkah') {
                $hotel_avaialabel = DB::table('dat_hotel_seat')
                ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
                ->where('dat_hotel.lokasi', 'mekkah')
                ->whereNotIn('dat_hotel_seat.kode_kamar', $durasi_hotel_mekkah)
                ->where('dat_hotel.kode_hotel', $request->kode_hotel)
                ->where('dat_hotel_seat.lantai', $request->lantai)
                ->select('dat_hotel_seat.kode_hotel', 'dat_hotel_seat.kode_kamar', 'dat_hotel_seat.lantai', 'dat_hotel_seat.nomor_kamar', 'dat_hotel.nama_hotel')
                ->get();

                foreach ($hotel_avaialabel as $item) {
                    $arr = [
                        'kode_hotel' => $item->kode_hotel,
                        'kode_kamar' => $item->kode_kamar,
                        'lantai' => $item->lantai,
                        'nomor_kamar' => $item->nomor_kamar,
                        'nama_hotel' => $item->nama_hotel,
                        'status' => true
                    ];
                    array_push($hotel_availabel_mekkah, $arr);
                }

                $hotel_not_avaialabel = DB::table('dat_hotel_seat')
                ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
                ->where('dat_hotel.lokasi', 'mekkah')
                ->whereIn('dat_hotel_seat.kode_kamar', $durasi_hotel_mekkah)
                ->where('dat_hotel.kode_hotel', $request->kode_hotel)
                ->where('dat_hotel_seat.lantai', $request->lantai)
                ->select('dat_hotel_seat.kode_hotel', 'dat_hotel_seat.kode_kamar', 'dat_hotel_seat.lantai', 'dat_hotel_seat.nomor_kamar', 'dat_hotel.nama_hotel')
                ->get();

                foreach ($hotel_not_avaialabel as $item) {
                    $arr = [
                        'kode_hotel' => $item->kode_hotel,
                        'kode_kamar' => $item->kode_kamar,
                        'lantai' => $item->lantai,
                        'nomor_kamar' => $item->nomor_kamar,
                        'nama_hotel' => $item->nama_hotel,
                        'status' => false
                    ];
                    array_push($hotel_availabel_mekkah, $arr);
                }

                return $hotel_availabel_mekkah;
            }
        }catch (\Exception $exception){
            return JsonStatus::messageException($exception);
        }
    }

    public function getHotelUser(Request $request)
    {
        $hotel_madinah = DB::table('transaksi_hotel')
        ->join('dat_hotel_seat', 'transaksi_hotel.kode_kamar', 'dat_hotel_seat.kode_kamar')
        ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
        ->where('transaksi_hotel.nomor_transaksi', $request->nomor_transaksi)
        ->where('dat_hotel.lokasi', 'madinah')
        ->select('dat_hotel.nama_hotel', 'dat_hotel_seat.nomor_kamar', 'dat_hotel_seat.lantai')
        ->first();

        $hotel_mekkah = DB::table('transaksi_hotel_mekkah')
        ->join('dat_hotel_seat', 'transaksi_hotel_mekkah.kode_kamar', 'dat_hotel_seat.kode_kamar')
        ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
        ->where('transaksi_hotel_mekkah.nomor_transaksi', $request->nomor_transaksi)
        ->where('dat_hotel.lokasi', 'mekkah')
        ->select('dat_hotel.nama_hotel', 'dat_hotel_seat.nomor_kamar', 'dat_hotel_seat.lantai')
        ->first();

        return ['madinah' => $hotel_madinah, 'mekkah' => $hotel_mekkah];
    }

    public function getPesertaHotel(Request $request)
    {
        try{
            $get_user_hotel = transaksi_hotel::where('nomor_transaksi', $request->nomor_transaksi)->first();
            if($get_user_hotel){
                $group_hotel = DB::table('transaksi_hotel')
                ->join('transaksi', 'transaksi_hotel.nomor_transaksi', 'transaksi.nomor_transaksi')
                ->join('peserta', 'transaksi.nomor_peserta', 'peserta.nomor_peserta')
                ->join('pendaftar', 'peserta.nomor_pendaftar', 'pendaftar.nomor_pendaftar')
                ->where('transaksi_hotel.kode_kamar', $get_user_hotel->kode_kamar)
                ->where('transaksi_hotel.kode_produk', $get_user_hotel->kode_produk)
                ->select('pendaftar.nama', 'pendaftar.hubungan_keluarga', 'transaksi.nomor_peserta')
                ->get();
                return $group_hotel;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
        
    }

}
