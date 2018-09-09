<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class travel extends Model
{
    protected $table = 'travel';

    public static function simpan($req)
    {
    	try {
	    	$table = new self;
	    	$table->kode_travel = 'TRV'.rand(000, 999);
	    	$table->nama_travel = $req->nama_travel;
	    	$table->logo_travel = $req->logo_travel;
	    	$table->website = $req->website;
	    	$table->save();

	    	return $table;
    	} catch (\Exception $e) {
			return $e->getMessage();    		
    	}
    }
}
