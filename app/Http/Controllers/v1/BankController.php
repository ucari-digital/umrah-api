<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Helper\Response;
use App\Model\bank;
class BankController extends Controller
{
    public function data()
    {
    	try {
    		$bank = bank::all();
    		return Response::json($bank, 'Berhasil mengambil query', 'success', 200);
    	} catch (Exception $e) {
    		return Response::json($e->getMessage(), 'Error', 'failed', 500);
    	}
    }
}
