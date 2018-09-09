<?php

namespace App\Http\Controllers\v1;

use App\Model\JsonStatus;
use App\Model\pendaftar;
use App\Model\perusahaan;
use App\Model\peserta;
use App\Model\Validate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class PerusahaanController extends Controller
{
    public function getperusahaan(){
        $data = perusahaan::all();

        return JsonStatus::messagewithData(200,'berhasil', $data);
    }

    public function perusahaanSearch(Request $request)
    {
        $perusahaan = perusahaan::where('domain', $request->domain)->first();
        return $perusahaan;
    }
    

    public function postperusahaan(Request $request){
        DB::beginTransaction();
        try{

            $validator = Validate::perusahaan($request);

            if ($validator->fails()) {
                return JsonStatus::messagewithData(400,'validasi', $validator->errors());
            }

            $model = $request->input();
            $model['kode_perusahaan'] = random_int(10000000,99999999);
            $model['slug'] = str_slug($request->nama, '-');
            perusahaan::insert($model);
        }catch (\Exception $exception){
            DB::rollback();
            return JsonStatus::messageException($exception);
        }
        DB::commit();
        return JsonStatus::message(200,'berhasil di simpan');
    }

    public function getpendaftar($kode_perusahaan){
        $data = pendaftar::getpendaftarbyperusahaan($kode_perusahaan);

        return JsonStatus::messagewithData(200,'berhasil',$data);
    }

}
