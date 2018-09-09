<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\dat_pesawat;
use App\Helper\Response;
class dat_pesawat_seat extends Model
{
    protected $table = 'dat_pesawat_seat';

    public static function insert($request)
    {
        try{
            $data = dat_pesawat::where('kode_pesawat', $request->kode_pesawat)->first();

            if($data){
                $table = new self;
                $table->kode_pesawat = $request->kode_pesawat;
                $table->kode_kursi = $request->kode_pesawat.''.$request->kursi;
                $table->kursi = $request->kursi;
                $table->save();
                return Response::json($table, 'berhasil memuat data', 'success', 200);
            } else {
                return Response::json('', 'kode pesawat tidak ditemukan', 'failed', 404);
            }
            
        } catch (\Exception $e) {
            return Response::json($e, 'Error', 'failed', 500);
        }

    }
}
