<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    protected $table = 'bank';

    public static function simpan($req)
    {
    	try {

    		$table = new self;
    		$table->kode_bank = $req->kode_bank;
    		$table->nama_bank = $req->nama_bank;
    		$table->no_rek = $req->no_rek;
    		$table->save();

    		return $table;
    	} catch (\Exception $e) {
    		return $e->getMessage();  
    	}
    }
}
