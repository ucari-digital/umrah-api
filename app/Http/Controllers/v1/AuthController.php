<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use DB;
use App\Model\peserta;
use App\Model\transaksi;
use App\Model\pendaftar;
use App\Model\transaksi_dokumen;

// 3Rd, Helper
use \Firebase\JWT\JWT;
use App\Helper\Response;
use App\Helper\Guzzle;
use App\Helper\Sms;
class AuthController extends Controller
{
    static function loginFinder($kontak, $password)
    {
        try{
            if (filter_var($kontak, FILTER_VALIDATE_EMAIL)) {
                $user = pendaftar::where('email', $kontak)->where('status', 'approved')->first();
                if ($user) {
                    if (Hash::check($password, $user->password)) {
                        return [
                            'data' => $user,
                            'login' => true
                        ];
                    } else {
                        return [
                            'data' => null,
                            'login' => false
                        ];
                    }
                } else {
                    return [
                        'data' => null,
                        'login' => false
                    ];
                }
                
            } else {
                $user = pendaftar::where('telephone', $kontak)->where('status', 'approved')->first();
                if ($user) {
                    if (Hash::check($password, $user->password)) {
                        return [
                            'data' => $user,
                            'login' => true
                        ];
                    } else {
                        return [
                            'data' => null,
                            'login' => false
                        ];
                    }
                } else {
                    return [
                        'data' => null,
                        'login' => false
                    ];
                }
            }

        } catch (\Exception $e) {
            return Response::json($e->getMessage(), 'Error', 'failed', 500);
        }
    }

    public function login(Request $request)
    {
        
        try{
            $response_login = self::loginFinder($request->header('x-ephone'), $request->header('x-password'));
            if ($response_login['login']) {
                $key = "DN4_UhAj";
                $token = array(
                    "iss" => env('TOKEN_ISS', ''),
                    "aud" => env('TOKEN_AUD', ''),
                    "nbf" => strtotime('now'),
                    "exp" => strtotime("+5 hours")
                    // "exp" => strtotime("+1 minutes")
                );

                $jwt = JWT::encode($token, $key);
                $decoded = JWT::decode($jwt, $key, array('HS256'));

                $arr_token = [
                    'token' => $jwt,
                    'generate'=> $decoded->nbf,
                    'expired' => $decoded->exp
                ];

                $nomor_peserta = peserta::where('nomor_pendaftar', $response_login['data']['nomor_pendaftar'])->first();
                $transaksi = transaksi::where('nomor_peserta', $nomor_peserta->nomor_peserta)->where('status', 'approved')->first();

                // Mengecek apakah transaksi null atau tidak
                if ($transaksi) {
                    $foto = transaksi_dokumen::where('nomor_transaksi', $transaksi->nomor_transaksi)->first();
                } else {
                    $foto = [];
                }

                $arr_token['user'] = $response_login['data'];
                $arr_token['user']['nomor_peserta'] = $nomor_peserta->nomor_peserta;
                if ($transaksi) {
                    $arr_token['user']['nomor_transaksi'] = $transaksi->nomor_transaksi;
                    $arr_token['user']['kode_produk'] = $transaksi->kode_produk;
                    if($foto){
                        $arr_token['user']['foto'] = $foto->foto;
                    } else {
                        $arr_token['user']['foto'] = null;
                    }
                } else {
                    $arr_token['user']['nomor_transaksi'] = '';
                    $arr_token['user']['kode_produk'] = '';
                    $arr_token['user']['foto'] = null;
                }

                $data = peserta::where('nomor_pendaftar', $response_login['data']['nomor_pendaftar'])
                ->update(['token' => $jwt]);

                return Response::json($arr_token, 'Generated Token', 'success', 200);
            } else {
                return Response::json('', 'Email atau password salah', 'success', 200);
            }
        } catch (\Exception $e){
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
        
    }

    /**
    * Validasi resert password. jika benar maka akan kirim pin untuk reset password
    */
    public function resetPasswordSms(Request $request)
    {
        $peserta = DB::table('peserta')
        ->join('pendaftar', 'peserta.nomor_pendaftar', 'pendaftar.nomor_pendaftar')
        ->join('travel', 'pendaftar.kode_travel', 'travel.kode_travel')
        ->where('pendaftar.telephone', $request->phone)
        ->select('pendaftar.telephone', 'travel.nama_travel', 'peserta.nomor_peserta')
        ->first();

        if ($peserta) {
            $code = rand(000000, 999999);

            peserta::where('nomor_peserta', $peserta->nomor_peserta)->update([
                'reset_pin' => $code
            ]);

            $param = [];
            $param['number'] = $peserta->telephone;
            $param['text'] = 'Gunakan kode '.$code.' untuk me-reset password umrah '.$peserta->nama_travel.' Anda. Jangan berikan kode ini pada siapapun demi alasan keamanan.';
            Sms::send($param);
            return Response::json(true, 'Berhasil mengambil query', 'success', 200);
        } else {
            return Response::json(false, 'Berhasil mengambil query', 'failed', 200);
        }
    }

    public function resetPasswordPin(Request $request)
    {
        $peserta = DB::table('peserta')
        ->join('pendaftar', 'peserta.nomor_pendaftar', 'pendaftar.nomor_pendaftar')
        ->join('travel', 'pendaftar.kode_travel', 'travel.kode_travel')
        ->where('peserta.reset_pin', $request->pin)
        ->select('pendaftar.telephone', 'travel.nama_travel')
        ->first();

        if ($peserta) {
            return Response::json(true, 'Berhasil mengambil query', 'success', 200);
        } else {
            return Response::json(false, 'Berhasil mengambil query', 'failed', 200);
        }
    }

    public function resetPassword(Request $request)
    {
        $peserta = peserta::where('reset_pin', $request->pin)->first();
        if ($peserta) {
            pendaftar::where('nomor_pendaftar', $peserta->nomor_pendaftar)->update([
                'password' => Hash::make($request->password)
            ]);
            peserta::where('reset_pin', $request->pin)->update([
                'reset_pin' => null
            ]);

            return Response::json(true, 'Berhasil mengambil query', 'success', 200);
        } else {
            return Response::json(false, 'Berhasil mengambil query', 'failed', 200);
        }
    }

    public function checkPin(Request $request)
    {
        try{
            $pin = peserta::where('nomor_peserta', $request->nomor_peserta)->where('pin', $request->pin)->first();
            if($pin){
                return Response::json($request->pin, 'pin benar', 'success', 200);
            } else {
                return Response::json('', 'pin salah', 'success', 200);
            }
        } catch (\Exception $e) {
            return Response::json($e->getMessage(), 'Errors', 'failed', 500);
        }
    }
}
