<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Validate;
// Model
use App\Model\transaksi_pesawat;
use App\Model\dat_pesawat_seat;
use App\Model\dat_pesawat;
use App\Model\transaksi;
use DB;
use Auth;
// 3rd
use App\Helper\Response;
use App\Model\JsonStatus;
class PesawatController extends Controller
{
    public function transaksi(Request $request)
    {
        try {
            $validator = Validate::transaksi_pesawat($request);

            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            // Mengamil kode transaksi
            $check_kode_transaksi = transaksi::where('nomor_peserta', $request->nomor_peserta)->where('status', 'approved')->first();
            if(!isset($check_kode_transaksi)){
                return Response::json('', 'Tanggal keberangkatan belum diverifikasi', 'success', 200);
            }
            // pengecekan transaksi pesawat untuk menghindari duplikat pemesanan seat pesawat
            $cek_pesawat_seat = transaksi_pesawat::where('nomor_transaksi', $check_kode_transaksi->nomor_transaksi)->first();
            if (!$cek_pesawat_seat) {
                $check_kode_kursi = dat_pesawat_seat::where('kode_kursi', $request->kode_kursi)->first();
                if ($check_kode_kursi) {

                    // Validasi seat masih availabel atau sudah dibooking
                    $q_TPesawat = DB::table('transaksi')
                    ->join('transaksi_pesawat', 'transaksi.nomor_transaksi', 'transaksi_pesawat.nomor_transaksi')
                    ->where('kode_kursi', $request->kode_kursi)
                    ->where('kode_produk', $check_kode_transaksi->kode_produk)
                    ->first();
                    
                    if(isset($q_TPesawat)){
                        return Response::json('', 'Seat telah dipilih orang lain', 'success', 200);
                    } else {
                        $request['nomor_transaksi'] = $check_kode_transaksi->nomor_transaksi;
                        return Response::json(transaksi_pesawat::insert($request), 'Berhasil memilih kursi pesawat', 'success', 200);
                    }

                    
                } else {
                    return Response::json($validator->errors(), 'kode kursi tidak ditemukan', 'failed', 404);
                }
            } else {
                return Response::json('', 'Anda telah booking seat pesawat', 'success', 200);
            }

        } catch (\Exception $e) {
            return Response::json($e->getMessage(), 'Error', 'failed', 500);
        }
    }

    public function getTransaksi(Request $request)
    {
        $transaksi_pesawat = DB::table('transaksi')
            ->join('transaksi_pesawat', 'transaksi.nomor_transaksi', '=', 'transaksi_pesawat.nomor_transaksi')
            ->join('dat_pesawat_seat', 'transaksi_pesawat.kode_kursi', '=', 'dat_pesawat_seat.kode_kursi')
            ->join('dat_pesawat', 'dat_pesawat_seat.kode_pesawat', '=', 'dat_pesawat.kode_pesawat')
            ->select('dat_pesawat_seat.kode_kursi', 'dat_pesawat_seat.kursi', 'dat_pesawat.nama_pesawat')
            ->where('transaksi_pesawat.nomor_transaksi', $request->nomor_transaksi)
            ->get();
            
        return $transaksi_pesawat;
    }

    public function add_dat_pesawat_seat(Request $request)
    {
        try {
            $validator = Validate::dat_pesawat_seat($request);

            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            return dat_pesawat_seat::insert($request);

        } catch (\Exception $e) {
            return Response::json($e, 'Error', 'failed', 500);
        }
    }

    public function add_dat_pesawat(Request $request)
    {
        try{
            $validator = Validate::dat_pesawat($request);

            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            return dat_pesawat::insert($request);
        } catch (\Exception $e) {
            return Response::json($e, 'Error', 'failed', 500);
        }
    }

    public function getAvailabelSeat(Request $request)
    {
        try{
            $pesawat_query = DB::table('transaksi_pesawat')
            ->join('dat_pesawat_seat', 'transaksi_pesawat.kode_kursi', '=', 'dat_pesawat_seat.kode_kursi')
            ->join('transaksi', 'transaksi_pesawat.nomor_transaksi', '=', 'transaksi.nomor_transaksi')
            ->select('transaksi_pesawat.nomor_transaksi', 'dat_pesawat_seat.kode_kursi', 'transaksi.kode_produk')
            // ->where('dat_pesawat_seat.kode_kursi', $request->kode_kursi)
            ->where('transaksi.kode_produk', $request->kode_produk)
            ->where('dat_pesawat_seat.kode_pesawat', $request->kode_pesawat)
            ->get();
            return Response::json($pesawat_query, 'Berhasil mengambil query', 'success', 200);
        } catch (\Exception $e) {
            return Response::json($e->getMessage() , 'Error', 'failed', 500);
        }
    }

    public function revert(Request $request)
    {
        try {
            $pesawat = DB::table('transaksi')
            ->join('transaksi_pesawat', 'transaksi.nomor_transaksi', 'transaksi_pesawat.nomor_transaksi')
            ->where('nomor_peserta', $request->nomor_peserta)
            ->where('kode_kursi', $request->kode_kursi)
            ->where('transaksi.status', 'approved')
            ->first();

            if ($pesawat) {
                transaksi_pesawat::where('nomor_transaksi', $pesawat->nomor_transaksi)
                ->delete();
                return Response::json($pesawat, 'Berhasil menghapus data', 'success', 200);
            } else {
                return Response::json($pesawat, 'Gagal menghapus data', 'failed', 200);
            }

            
        } catch (\Exception $e) {
            return Response::json($e->getMessage() , 'Error', 'failed', 500);
        }
    }
}
