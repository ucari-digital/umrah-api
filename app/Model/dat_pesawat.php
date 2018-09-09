<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Response;
class dat_pesawat extends Model
{
    protected $table = 'dat_pesawat';

    public static function insert($request)
    {
        try{
            $table = new self;
            $table->kode_pesawat = 'PSW'.rand(1000,9999);
            $table->nama_pesawat = $request->nama_pesawat;
            $table->created_by = 'admin';
            $table->save();
            return $table;            
        } catch(\Exception $e) {
            return Response::json($e, 'Error', 'failed', 500);
        }
    }
}
