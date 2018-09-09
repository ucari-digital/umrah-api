<?php

namespace App\Http\Controllers\v1;

use App\Model\pendaftar;
use App\Model\JsonStatus;
use App\Model\peserta;
use App\Model\Validate;
use App\Model\transaksi_dokumen;
use Illuminate\Http\Request;
use DB;
use Validator;
use Hash;
use App\Http\Controllers\Controller;
use App\Helper\Response;

class PendaftaranController extends Controller
{
    public function getpendaftar(){
        try{
            $data = pendaftar::select('pendaftar.*','perusahaan.nama as nama_perusahaan')
                ->join('perusahaan','perusahaan.kode_perusahaan','=','pendaftar.kode_perusahaan')
                ->paginate(10);
        }catch (\Exception $exception){
            return JsonStatus::messageException($exception);
        }

        return JsonStatus::messagewithData(200,'berhasil', $data);
    }

    public function postdaftar(Request $request){
        DB::beginTransaction();
        try{


            $validate = Validate::pendaftar($request);

            if ($validate->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validate->errors());
            }

            // $noreff = pendaftar::ceknoreff($request->no_reff);
            // if (empty($noreff) && !empty($request->no_reff)){
            //     return JsonStatus::message(401, 'no reff tidak di temukan');
            // }
            $nomor_pendaftar = random_int(100000000,999999999);
            $model = $request->except(['nomor_peserta']);
            $model['nomor_pendaftar'] = $nomor_pendaftar;
            $model['password'] = Hash::make($request->password);
            $model['status'] = 'approved';
//            dd($model);
            pendaftar::insert($model);

            $peserta = new peserta();
            $peserta->nomor_pendaftar = $nomor_pendaftar;
            $peserta->nomor_peserta = $request->nomor_peserta;
            $peserta->pin = rand(1000,9999);
            $peserta->save();
        }catch (\Exception $exception){
            DB::rollback();
            return JsonStatus::messageException($exception);
        }
        DB::commit();
        return JsonStatus::message(200,'berhasil di simpan');
    }

    public function approvalpeserta(Request $request){
        $peserta = peserta::where('nomor_peserta', $request->nomor_peserta )
        ->update(['status' => $request->status]);
        return $peserta;
    }

    public function getpeserta(){
        $data = peserta::paginate(10);
        return JsonStatus::messagewithData(200,'bergasil',$data);
    }

    public function getPendaftarReff(Request $request)
    {
        try{
            $pendaftar = pendaftar::where('no_reff', $request->no_reff)
            ->select('nama')
            ->get();
            return Response::json($pendaftar, 'Berhasil mengambil query', 'success', 200);
        } catch(\Exception $e) {
            return Response::json($pendaftar, 'Error', 'failed', 500); 
        }

    }

    public function getPesertaDetail(Request $request)
    {
        try{
            $pendaftar = DB::table('pendaftar')
            ->join('peserta', 'pendaftar.nomor_pendaftar', 'peserta.nomor_pendaftar')
            ->join('transaksi', 'peserta.nomor_peserta', 'transaksi.nomor_peserta')
            ->where('peserta.nomor_peserta', $request->nomor_peserta)
            ->select('pendaftar.nama', 'pendaftar.email', 'pendaftar.telephone', 'pendaftar.nip', 'pendaftar.jk', 'pendaftar.nip' , 'peserta.nomor_peserta', 'transaksi.nomor_transaksi', 'transaksi.kode_produk')
            ->first();

            if ($pendaftar) {
                $peserta = transaksi_dokumen::where('nomor_transaksi', $pendaftar->nomor_transaksi)->first();
                if($peserta){
                    $collection = collect($pendaftar);
                    $collection->put('foto', $peserta->foto);
                } else {
                    $collection = collect($pendaftar);
                    $collection->put('foto', null);
                }
            } else {
                $collection = collect($pendaftar);
                $collection->put('kode_produk', null);
                $collection->put('foto', null);
            }

            return Response::json($collection, 'Berhasil mengambil query', 'success', 200);
        } catch(\Exception $e){
            return Response::json($e->getMessage(), 'Error', 'failed', 500);
        }
    }

}
