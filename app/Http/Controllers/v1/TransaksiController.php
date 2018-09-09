<?php

namespace App\Http\Controllers\v1;

use App\Model\helper;
use App\Model\JsonStatus;
use App\Model\peserta;
use App\Model\produk;
use App\Model\durasi_hotel;
use App\Model\transaksi;
use App\Model\transaksi_dokumen;
use App\Model\transaksi_dokumen_dumper;
use App\Model\transaksi_hotel;
use App\Model\transaksi_hotel_mekkah;
use App\Model\transaksi_pembayaran;
use App\Model\transaksi_pesawat;
use App\Model\Validate;
use App\Helper\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{

    /**
     * Transaksi Umrah
     */
    public function posttransaksi(Request $request){
        DB::begintransaction();
        // try{

            $validator = Validate::transaksi($request);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            $cekproduk = produk::getonerow($request->kode_produk,'harga');
            $cekpeserta = peserta::getonerow($request->nomor_peserta,'pin');
            if (empty($cekproduk)){
                return JsonStatus::message(401,'Produk Tidak Di temukan');
            }

            if (empty($cekpeserta)){
                return JsonStatus::message(401,'Nomor Peserta Tidak Di temukan');
            }
            $cek_duplikasi_data = transaksi::where('nomor_peserta', $request->nomor_peserta)
            ->where('kode_produk', $request->kode_produk)
            ->first();
            if($cek_duplikasi_data){
                return JsonStatus::message(401,'Anda telah memilih tanggal dan paket yang sama');
            }

            $tgl_sekarang = Carbon::now()->toDateString();
            $model = $request->input();
            $model['nomor_transaksi'] = 'TRUMH'.random_int(10000,99999).str_replace('-','',$tgl_sekarang);
            $model['tgl_transaksi'] = Carbon::now();
            $model['exp_booking'] = Carbon::now()->addDay(5);
            $model['total_harga'] = produk::getonedata($request->kode_produk,'harga');
            /**
             * status terdiri menjadi 2
             * booking, approved
             * booking berarti proses sedang berjalan dan belum mendapatkan varifikasi dari admin
             * approved berarti sudah mendapat persetujuan dari admin
             */
            $model['status'] = 'approved';
            transaksi::insert($model);

            // import transaksi dokumen dumper ke transaksi dokumen
            $dokumen = transaksi_dokumen_dumper::where('nomor_peserta', $request->nomor_peserta)->first();
            if ($dokumen) {
                $field = new transaksi_dokumen;
                $field->nomor_transaksi = $model['nomor_transaksi'];
                $field->foto = $dokumen->foto;
                $field->passpor = $dokumen->passpor;
                $field->ktp = $dokumen->ktp;
                $field->kartu_keluarga = $dokumen->kartu_keluarga;
                $field->kartu_karyawan = $dokumen->kartu_karyawan;
                $field->buku_nikah = $dokumen->buku_nikah;
                $field->akta = $dokumen->akta;
                $field->kartu_kuning = $dokumen->kartu_kuning;
                $field->foto_status = $dokumen->foto_status;
                $field->passpor_status = $dokumen->passpor_status;
                $field->ktp_status = $dokumen->ktp_status;
                $field->kartu_keluarga_status = $dokumen->kartu_keluarga_status;
                $field->kartu_karyawan_status = $dokumen->kartu_karyawan_status;
                $field->buku_nikah_status = $dokumen->buku_nikah_status;
                $field->akta_status = $dokumen->akta_status;
                $field->kartu_kuning_status = $dokumen->kartu_kuning_status;
                $field->save();

                transaksi_dokumen_dumper::where('nomor_peserta', $request->nomor_peserta)->delete();
            }

        // }catch (\Exception $exception){
        //     DB::rollback();
        //     return JsonStatus::messageException($exception);
        // }
        DB::commit();
        return JsonStatus::message(200,'berhasil di simpan');
    }

    public function gettransaksi(Request $request){
        $peserta = peserta::getnomorpeserta($request->nomor_peserta);

        $data = transaksi::gettransaksiuser($peserta);

        return JsonStatus::messagewithData(200,'berhasil mengambil data', $data);
    }

    public function getTglKeberangkatan(Request $request)
    {
        $transaksi = DB::table('transaksi')
        ->join('produk', 'transaksi.kode_produk', 'produk.kode_produk')
        ->where('transaksi.nomor_transaksi', $request->nomor_transaksi)
        ->where('transaksi.status', 'approved')
        ->select('produk.tanggal_keberangkatan')
        ->first();
        return Response::json($transaksi, 'Berhasil mengambil query', 'success', 200);
    }

    /**
     * Transaksi Document
     */
    public function posttransaksidocument(Request $request){
        DB::begintransaction();
        // try{
            $validator = Validate::transaksidokumen($request);
            $peserta = peserta::getnomorpeserta($request->nomor_peserta);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            $cek_dokumen = transaksi_dokumen::cektransaksi($request->nomor_transaksi);
            $cek_dokumen_dumper = transaksi_dokumen_dumper::where('nomor_peserta', $request->nomor_peserta)->first();
            if (!empty($cek_dokumen)){
                $table = transaksi_dokumen::find($cek_dokumen->id);
                $status = 'pending';
            } elseif (!empty($cek_dokumen_dumper)) {
                $table = transaksi_dokumen_dumper::find($cek_dokumen_dumper->id);
                $status = 'pending';
            } else {
                if ($request->table == 'dumper') {
                    $table = new transaksi_dokumen_dumper;
                    $table->nomor_peserta = $request->nomor_peserta;
                } else {
                    $table = new transaksi_dokumen;
                }
                $table->nomor_transaksi = $request->nomor_transaksi;
                $table->tgl_upload = Carbon::now();
                $table->exp_payment = Carbon::now()->addDay(3);
                $status = 'pending';
            }
            if($request->field == 'passpor'){
                $table->passpor = $request->file;
                $table->passpor_status = $status;
            }
            
            if($request->field == 'ktp'){
                $table->ktp = $request->file;
                $table->ktp_status = $status;
            }
            
            if($request->field == 'foto'){
                $table->foto = $request->file;
                $table->foto_status = $status;
            }

            if($request->field == 'kartu-keluarga'){
                $table->kartu_keluarga = $request->file;
                $table->kartu_keluarga_status = $status;
            }

            if($request->field == 'buku-nikah'){
                $table->buku_nikah = $request->file;
                $table->buku_nikah_status = $status;
            }

            if($request->field == 'akta-kelahiran'){
                $table->akta = $request->file;
                $table->akta_status = $status;
            }

            if($request->field == 'kartu-kuning'){
                $table->kartu_kuning = $request->file;
                $table->kartu_kuning_status = $status;
            }

            if($request->field == 'id-karyawan'){
                $table->kartu_karyawan = $request->file;
                $table->kartu_karyawan_status = $status;
            }
            $table->save();

        // }catch (\Exception $exception){
        //     DB::rollback();
        //     return JsonStatus::messageException($exception);
        // }
        DB::commit();
        return JsonStatus::message(200,'berhasil di simpan');
    }

    public function getTransaksiDokumen(Request $request)
    {
        $transaksi_dokumen = DB::table('transaksi')
            ->join('produk', 'transaksi.kode_produk', 'produk.kode_produk')
            ->select('produk.tanggal_keberangkatan')
            ->where('transaksi.nomor_transaksi', $request->nomor_transaksi)
            ->get();
        return Response::json($transaksi_dokumen, 'Berhasil mengambil query', 'success', 200);
    }

    public static function posttransaksipembayaran(Request $request){
        DB::begintransaction();
        try{
            $validator = Validate::transaksipembayaran($request);
            $peserta = peserta::getnomorpeserta($request->nomor_peserta);
            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            $cek = transaksi::cektransaksi($request->nomor_transaksi,$peserta);
            if (empty($cek)){
                return JsonStatus::message(401,'nomor transaksi tidak di temukan');
            }

            $status_file_upload = new StatusTransaksiController;
            $dokumen = $status_file_upload->statusDetail($request);
            if (!$dokumen['status_dokumen']){
                return JsonStatus::message(401,'Dokumen belum lengkap');
            }

            // $totalpembayaran = transaksi_pembayaran::where('nomor_transaksi',$request->nomor_transaksi)->sum('jumlah_pembayaran');
            // $totalpembayaran = $totalpembayaran + $request->jumlah_pembayaran;
            // if ($cek->total_harga < $totalpembayaran){
            //     return JsonStatus::message(400,'jumlah pembayaran lebih besar dari total harga');
            // }
            $model = $request->input();
            $model['nomor_pembayaran'] = 'PAY'.helper::replacedate(Carbon::now());
            transaksi_pembayaran::insert($model);

        }catch (\Exception $exception){
            DB::rollback();
            return JsonStatus::messageException($exception);
        }
        DB::commit();
        return JsonStatus::message(200,'pembayaran berhasil');
    }

    public function historyPembayaran(Request $request)
    {
        try{
            $transaksi = transaksi_pembayaran::where('nomor_transaksi', $request->nomor_transaksi)->get();
            return Response::json($transaksi, 'berhasil mengambil query', 'success', 200);
        } catch (\Exception $e) {
            return Response::json($e->getMessage(), 'Error', 'failed', 500);
        }
    }

    public function transaksiUserDetail(Request $request)
    {
        try{
            if($request->result == 'array'){
                $transaksi = transaksi::where('nomor_peserta', $request->nomor_peserta)
                ->where('status', $request->status)
                ->get();
            } else {
                $transaksi = transaksi::where('nomor_peserta', $request->nomor_peserta)
                ->where('status', $request->status)
                ->first();
            }
            return $transaksi;
        } catch(\Exception $e) {
            return Response::json($e->getMessage(), 'Error', 'failed', 500);
        }
    }

    /**
     * Transaksi Cancel
     */

    // Pesawat
    public function pesawatCancel(Request $request)
    {
        try{
            $pesawat = transaksi_pesawat::where('nomor_transaksi', $request->nomor_transaksi)->delete();
            return Response::json($pesawat, 'berhasil mengambil query', 'success', 200);
        } catch (\Exception $e){
            return Response::json($e->getMessage(), 'Error', 'failed', 500);
        }
    }

    public function paketCancel(Request $request)
    {
        try{
            $paket = transaksi::where('nomor_transaksi', $request->nomor_transaksi)->delete();
            $pesawat = transaksi_pesawat::where('nomor_transaksi', $request->nomor_transaksi)->delete();
            $hotel = transaksi_hotel::where('nomor_transaksi', $request->nomor_transaksi)->first();
            $hotel_mekkah = transaksi_hotel_mekkah::where('nomor_transaksi', $request->nomor_transaksi)->first();
            $dokumen = transaksi_dokumen::where('nomor_transaksi', $request->nomor_transaksi)->delete();
            $pembayaran = transaksi_pembayaran::where('nomor_transaksi', $request->nomor_transaksi)->delete();
            /**
             * Menghapus user lain ketika pemberangkatan dibatalkan
             */
            if($hotel){
                $del_hotel = transaksi_hotel::where('kode_produk', $hotel->kode_produk)
                ->where('kode_kamar', $hotel->kode_kamar)
                ->where('status', 'approved')
                ->delete();
                $durasi_hotel = durasi_hotel::where('kode_produk', $hotel->kode_produk)
                ->where('kode_kamar', $hotel->kode_kamar)
                ->delete();
            } else {
                $del_hotel = null;
                $durasi_hotel = null;
            }

            /**
            * Menghapus user lain ketika pemberangkatan dibatalkan
            */
            if($hotel_mekkah){
                $del_hotel_mekkah = transaksi_hotel_mekkah::where('kode_produk', $hotel_mekkah->kode_produk)
                ->where('kode_kamar', $hotel_mekkah->kode_kamar)
                ->where('status', 'approved')
                ->delete();
                $durasi_hotel_mekkah = durasi_hotel::where('kode_produk', $hotel_mekkah->kode_produk)
                ->where('kode_kamar', $hotel_mekkah->kode_kamar)
                ->delete();
            } else {
                $del_hotel_mekkah = null;
                $durasi_hotel_mekkah = null;
            }

            $response = [
                'paket' => $paket,
                'pesawat' => $pesawat,
                'hotel' => $del_hotel,
                'hotel_mekkah' => $del_hotel_mekkah,
                'durasi_hotel' => $durasi_hotel,
                'durasi_hotel_mekkah' => $durasi_hotel_mekkah,
                'dokumen' => $dokumen,
                'pembayaran' => $pembayaran
            ];
            return Response::json($response, 'berhasil mengambil query', 'success', 200);
        } catch (\Exception $e){
            return Response::json($e->getMessage(), 'Error', 'failed', 500);
        }
    }

}
