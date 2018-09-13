<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Helper\Response;
use App\Model\travel;
class TravelController extends Controller
{
    public function data()
    {
    	try {
    		$travel = travel::where('status', '!=', 'false')->get();
    		return Response::json($travel, 'Berhasil mengambil query', 'success', 200);
    	} catch (Exception $e) {
    		return Response::json($e->getMessage(), 'Error', 'failed', 500);
    	}
    }
}
