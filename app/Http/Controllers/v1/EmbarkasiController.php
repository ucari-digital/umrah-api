<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\embarkasi;
use App\Helper\Response;

class EmbarkasiController extends Controller
{
    public function getEmbarkasi()
    {
        $embarkasi = embarkasi::where('status', 'Y')->get();
        return Response::json($embarkasi, 'berhasil mengambil query', 'success', 200);
    }
}
