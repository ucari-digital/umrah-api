<?php

namespace App\Model;

class JsonStatus
{
    public static function message($status, $msg){
        return response()->json(['status'=> $status, 'msg' => $msg]);
    }

    public static function messagewithurl($status, $msg, $url){
        return response()->json(['status'=> $status, 'msg' => $msg, 'url' => $url]);
    }

    public static function messagewithId($status, $msg, $id){
        return response()->json(['status'=> $status, 'msg' => $msg, 'id' => $id]);
    }

    public static function messagewithurlId($status, $msg, $url, $id){
        return response()->json(['status'=> $status, 'msg' => $msg, 'url' => $url, 'id' => $id]);
    }

    public static function messagewithData($status, $msg, $data){
        return response()->json(['status'=> $status, 'msg' => $msg, 'data' => $data]);
    }

    public static function messagewithView($status, $msg, $data, $view){
        return response()->json(['status'=> $status, 'msg' => $msg, 'data' => $data, 'view' => view($view, compact('data'))->render()]);

    }

    public static function messagewithViewData($status, $msg, $data, $view){
        return response()->json(['status'=> $status, 'msg' => $msg, 'data' => $data, 'view' => view($view, $data)->render()]);

    }

    public static function messagewithViewUrl($status, $msg, $url, $view){
        return response()->json(['status'=> $status, 'msg' => $msg, 'url' => $url, 'view' => view($view)->render()]);

    }

    public static function messageException($exception){
        return response()->json(['status'=>500, 'msg'=>'Terjadi Kesalahan Pada Sistem '.$exception->getMessage().' File '.$exception->getFile().' Line '.$exception->getLine()]);
//        return response()->json(['status'=>400, 'msg'=>'Terjadi Kesalahan Pada Sistem :(']);
    }

    public static function responseData($status, $data){
        return response()->json(['status'=> $status, 'data' => $data]);
    }
}
