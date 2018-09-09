<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Response;
use App\Model\peserta;
use App\Model\transaksi;
use App\Model\transaksi_pesawat;
use App\Model\transaksi_dokumen;
use App\Model\transaksi_dokumen_dumper;
use DB;
class StatusTransaksiController extends Controller
{
    public function aksesTransaksi(Request $request)
    {
        $akses = transaksi::where('nomor_peserta', $request->nomor_peserta)
        ->where('status', 'approved')
        ->first();
        if($akses){
            return Response::json(true, 'Anda memiliki transaksi', 'success', 200);
        } else {
            return Response::json(false, 'Anda tidak memiliki transaksi', 'success', 200);
        }
    }

    public function statusAksesUmrah(Request $request)
    {
        try{
            $peserta = peserta::where('nomor_peserta', $request->nomor_peserta)
            ->where('status', 'approved')
            ->first();
            if ($peserta) {
                return Response::json(true, 'Dapat akses pemilihan tanggal keberangkatan', 'success', 200);
            } else {
                return Response::json(false, 'Tidak dapat akses', 'success', 200);
            }
        } catch(\Exception $e){
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }

    public function statusPesanUmrah(Request $request)
    {
        try{
            $transaksi = transaksi::where('nomor_peserta', $request->nomor_peserta)
            ->where(['status' => 'approved', 'status' => 'pending'])
            ->first();
            if ($transaksi) {
                return Response::json(false, 'Sudah memilih paket', 'success', 200);
            } else {
                return Response::json(true, 'Belum memilih paket', 'success', 200);
            }
        } catch(\Exception $e){
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }

    public function statusAksesSeat(Request $request)
    {
        try{
            $peserta = 
            $transaksi = transaksi::where('nomor_transaksi', $request->nomor_transaksi)
            ->where('status', 'approved')
            ->first();
            if ($transaksi) {
                return Response::json(true, 'Tanggal keberangkatan sudah diverifikasi', 'success', 200);
            } else {
                return Response::json(false, 'Tanggal keberangkatan belum diverifikasi', 'success', 200);
            }
        } catch (\Exception $e) {
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }

    public function statusPemesananSeat(Request $request)
    {
        try{
            $transaksi = transaksi_pesawat::where('nomor_transaksi', $request->nomor_transaksi)
            ->first();
            if ($transaksi) {
                return Response::json(false, 'Sudah memilih seat', 'success', 200);
            } else {
                return Response::json(true, 'Belum memilih seat', 'success', 200);
            }
        } catch(\Exception $e){
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        } 
    }

    /**
     * function ini untuk memvalidasi user yang sudah di approve atau belum
     */
    public function statusAksesPesertaHotel(Request $request)
    {
        try{
            $transaksi = DB::table('transaksi')
            ->join('peserta', 'transaksi.nomor_peserta', 'peserta.nomor_peserta')
            ->join('pendaftar', 'peserta.nomor_pendaftar', 'pendaftar.nomor_pendaftar')
            ->where('peserta.nomor_peserta', $request->nomor_peserta)
            ->where('peserta.pin', $request->pin)
            ->where('transaksi.status', 'approved')
            ->select('pendaftar.nama', 'transaksi.kode_produk')
            ->first();
            if ($transaksi) {
                return Response::json(true, $transaksi, 'success', 200);
            } else {
                return Response::json(false, 'Transaksi peserta belum diverifikasi', 'success', 200);
            }
        } catch(\Exception $e){
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }

    /**
     * function untuk mengecek status pemesana hotel
     */

    public function statusHotel(Request $request, $hotel)
    {
        try{
            if($hotel == 'madinah'){
                $transaksi_hotel = DB::table('transaksi_hotel')
                ->join('dat_hotel_seat', 'transaksi_hotel.kode_kamar', 'dat_hotel_seat.kode_kamar')
                ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
                ->where('transaksi_hotel.nomor_transaksi', $request->nomor_transaksi)
                ->where('dat_hotel.lokasi', 'madinah')
                ->where('transaksi_hotel.status', 'approved')
                ->first();
    
                if($transaksi_hotel){
                    return Response::json(true, 'Peserta telah memilih hotel', 'success', 200);
                } else {
                    return Response::json(false, 'Peserta belum memilih hotel', 'success', 200);
                }
            }
            
            if($hotel == 'mekkah'){
                $transaksi_hotel = DB::table('transaksi_hotel_mekkah')
                ->join('dat_hotel_seat', 'transaksi_hotel_mekkah.kode_kamar', 'dat_hotel_seat.kode_kamar')
                ->join('dat_hotel', 'dat_hotel_seat.kode_hotel', 'dat_hotel.kode_hotel')
                ->where('transaksi_hotel_mekkah.nomor_transaksi', $request->nomor_transaksi)
                ->where('dat_hotel.lokasi', 'mekkah')
                ->where('transaksi_hotel_mekkah.status', 'approved')
                ->first();
    
                if($transaksi_hotel){
                    return Response::json(true, 'Peserta telah memilih hotel', 'success', 200);
                } else {
                    return Response::json(false, 'Peserta belum memilih hotel', 'success', 200);
                }
            }
        } catch(\Exception $e){
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }

    /**
     * function ini di buat untuk memberi status dokumen yang telah di upload
     */

    public function statusFileUpload(Request $request)
    {
        try{
            if($request->table == 'dumper'){
                return $status = transaksi_dokumen_dumper::where('nomor_peserta', $request->nomor_peserta)
                ->first();
            } else {
                $status = transaksi_dokumen::where('nomor_transaksi', $request->nomor_transaksi)
                ->first();
            }

            if(empty($status)){
                $result = [
                    'passpor' => false,
                    'ktp' => false,
                    'foto' => false,
                    'kartu_keluarga' => false,
                    'kartu_karyawan' => false,
                    'kartu_kuning' => false,
                    'buku_nikah' => false,
                    'akta' => false
                ];
            } else {
                if($status->passpor_status == 'approved' or $status->passpor_status == 'pending' /*or !empty($status->passpor)*/){
                    $passpor = true;
                } else {
                    $passpor = false;
                }
    
                if($status->ktp_status == 'approved' or $status->ktp_status == 'pending' /*or !empty($status->ktp)*/){
                    $ktp = true;
                } else {
                    $ktp = false;
                }
                
                if($status->foto_status == 'approved' or $status->foto_status == 'pending' /*or !empty($status->foto)*/){
                    $foto = true;
                } else {
                    $foto = false;
                }
    
                if($status->kartu_keluarga_status == 'approved' or $status->kartu_keluarga_status == 'pending' /*or !empty($status->kartu_keluarga)*/){
                    $kartu_keluarga = true;
                } else {
                    $kartu_keluarga = false;
                }
    
                if($status->kartu_karyawan_status == 'approved' or $status->kartu_karyawan_status == 'pending' /*or !empty($status->kartu_karyawan)*/){
                    $kartu_karyawan = true;
                } else {
                    $kartu_karyawan = false;
                }
    
                if($status->buku_nikah_status == 'approved' or $status->buku_nikah_status == 'pending' /*or !empty($status->buku_nikah)*/){
                    $buku_nikah = true;
                } else {
                    $buku_nikah = false;
                }
    
                if($status->akta_status == 'approved' or $status->akta_status == 'pending' /*or !empty($status->akta)*/){
                    $akta = true;
                } else {
                    $akta = false;
                }
                
                if($status->kartu_kuning_status == 'approved' or $status->kartu_kuning_status == 'pending' /*or !empty($status->kartu_kuning)*/){
                    $kartu_kuning = true;
                } else {
                    $kartu_kuning = false;
                }
    
                $result = [
                    'passpor' => $passpor,
                    'ktp' => $ktp,
                    'foto' => $foto,
                    'kartu_keluarga' => $kartu_keluarga,
                    'kartu_karyawan' => $kartu_karyawan,
                    'kartu_kuning' => $kartu_kuning,
                    'buku_nikah' => $buku_nikah,
                    'akta' => $akta
                ];
            }

            
            return $result;
        } catch (\Exception $e){
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }

    /**
     * Status detail merupakan kumpulan dari beberapa status menjadi satu request
     * - nomor_peserta
     * - nomor_transaksi
     */
    public function statusDetail(Request $request)
    {
        $class = new self;
        $akses_transaksi = $class->aksesTransaksi($request);
        $status_seat = $class->statusPemesananSeat($request);
        $status_hotel = $class->statusHotel($request, 'madinah');
        $status_file_upload = $class->statusFileUpload($request);


        if($status_seat['data'] == true){
            // Belum memilih seat
            $status_seat = false;
        } else {
            // sudah memilih seat
            $status_seat = true;
        }

        /**
         * Status File upload DOKUMEN
         */
        if ($status_file_upload['passpor'] == true 
        && $status_file_upload['foto'] == true 
        && $status_file_upload['kartu_keluarga'] == true
        && $status_file_upload['kartu_kuning'] == true
        && $status_file_upload['kartu_karyawan'] == true) {
            $status_dokumen = true;
        } else {
            $status_dokumen = false;
        }

        return [
            'akses_transaksi' => $akses_transaksi['data'],
            'status_seat' => $status_seat,
            'status_hotel_madinah' => $status_hotel['data'],
            'status_hotel_mekkah' => $status_hotel['data'],
            'status_dokumen' => $status_dokumen
        ];
    }

}
