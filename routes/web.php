<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('a', function(){
    return 'abc';
});

Route::get('get-token', 'v1\TokenController@getToken');
Route::get('check-token', 'v1\TokenController@tokenValidator');
Route::post('perusahaan-search', 'v1\PerusahaanController@perusahaanSearch');

Route::middleware('token')->group(function(){
    Route::post('login', 'v1\AuthController@login');
    Route::post('register', 'v1\PendaftaranController@postdaftar');
});

//Route::middleware('loginToken')->group(function(){
    /**
     * AUTH
     */
    Route::group(['prefix' => 'auth'], function(){
        Route::post('pin', 'v1\AuthController@checkPin');
        Route::post('reset-password-validation', 'v1\AuthController@resetPasswordSms');
        Route::post('reset-password-pin', 'v1\AuthController@resetPasswordPin');
        Route::post('reset-password', 'v1\AuthController@resetPassword');
    });
    /**
     * pendaftar
     *
     */
    Route::group(['prefix' => 'pendaftar/'], function () {
        Route::get('getpendaftar', 'v1\PendaftaranController@getpendaftar');
        Route::post('getpendaftarreff', 'v1\PendaftaranController@getPendaftarReff');
        Route::post('get-pendaftar-detail', 'v1\PendaftaranController@getPesertaDetail');
    });

    /**
     * Embarkasi
     */
    Route::group(['prefix' => 'embarkasi/'], function () {
        Route::get('get-data', 'v1\EmbarkasiController@getEmbarkasi');
    });

    /**
    * Departemen
    */
    Route::prefix('departemen')->group(function(){
        Route::get('data', 'V1\DepartemenController@data');
    });

    /**
     * pendaftar
     *
     */
    Route::group(['prefix' => 'peserta/'], function () {
        Route::get('getpeserta', 'v1\PendaftaranController@getpeserta');
    });
    
    /**
     * Perusahaan
     */
    Route::group(['prefix' => 'produk/'], function () {
        Route::post('add', 'v1\ProdukController@postproduk');
        Route::post('getproduk', 'v1\ProdukController@getproduk');
        Route::post('detail', 'v1\ProdukController@produkDetail');
    });
    
    /**
     * Transaksi
     */
    Route::group(['prefix' => 'transaksi/'], function () {
        Route::post('add', 'v1\TransaksiController@posttransaksi');
        Route::post('gettransaksi', 'v1\TransaksiController@gettransaksi');
        Route::post('gettransaksidokumen', 'v1\TransaksiController@getTransaksiDokumen');
        Route::post('tglkeberangkatan', 'v1\TransaksiController@getTglKeberangkatan');
        Route::post('user-detail', 'v1\TransaksiController@transaksiUserDetail');
    });

    /**
     * Transaksi Dokument
     */
    Route::group(['prefix' => 'transaksi/dokument'], function () {
        Route::post('/', 'v1\TransaksiController@posttransaksidocument');
//        Route::get('/gettransaksi', 'v1\TransaksiController@gettransaksidocument');
    });

    /**
     * Transaksi Hotel
     */
    Route::group(['prefix' => 'transaksi/hotel'], function () {
        Route::post('/', 'v1\HotelController@posttransaksihotel');
    });

    /**
     * Transaksi Pembayaran
     */
    Route::group(['prefix' => 'transaksi/pembayaran'], function () {
        Route::post('/', 'v1\TransaksiController@posttransaksipembayaran');
        Route::post('history', 'v1\TransaksiController@historyPembayaran');
    });

    /**
     * Hotel
     */
    Route::group(['prefix' => 'hotel'], function () {
        Route::post('/addhotel', 'v1\HotelController@addhotel');
        Route::post('/addkamar', 'v1\HotelController@addkamar');
        Route::post('/gethotel', 'v1\HotelController@gethotel');
        Route::post('/getkamar', 'v1\HotelController@getkamar');
        Route::post('/get-kamar-availabel', 'v1\HotelController@getKamarAvailabel');
        Route::post('get-hotel-user', 'v1\HotelController@getHotelUser');
        Route::post('get-hotel-group', 'v1\HotelController@getPesertaHotel');
    });

    /**
     * Pesawat
     */
    Route::group(['prefix' => 'pesawat/'], function(){
        Route::post('add', 'v1\PesawatController@add_dat_pesawat');
        Route::post('transaksi', 'v1\PesawatController@transaksi');
        Route::post('gettransaksi', 'v1\PesawatController@getTransaksi');
        Route::post('addseat', 'v1\PesawatController@add_dat_pesawat_seat');
        Route::post('getavailabelseat', 'v1\PesawatController@getAvailabelSeat');
        Route::post('revert', 'v1\PesawatController@revert');
        
    });

    /**
     * Status Akses Transaksi
     */
    Route::group(['prefix' => 'status'], function(){
        Route::post('akses-umrah', 'v1\StatusTransaksiController@statusAksesUmrah');
        Route::post('pemesanan-umrah', 'v1\StatusTransaksiController@statusPesanUmrah');
        Route::post('akses-seat', 'v1\StatusTransaksiController@statusAksesSeat');
        Route::post('pemesanan-seat', 'v1\StatusTransaksiController@statusPemesananSeat');
        Route::post('akses-peserta-hotel', 'v1\StatusTransaksiController@statusAksesPesertaHotel');
        Route::post('transaksi', 'v1\StatusTransaksiController@aksesTransaksi');
        Route::post('status-file-upload', 'v1\StatusTransaksiController@statusFileUpload');
        Route::post('statusDetail', 'v1\StatusTransaksiController@statusDetail');
    });

    /**
     * Transaksi Cancel
     */
    Route::group(['prefix' => 'cancel'], function(){
        Route::post('seat', 'v1\TransaksiController@pesawatCancel');
        Route::post('produk', 'v1\TransaksiController@paketCancel');
    });

    /**
    * Travel
    */

    Route::group(['prefix' => 'travel'], function(){
        Route::get('data', 'v1\TravelController@data');
    });

    /**
    * Bank
    */

    Route::group(['prefix' => 'bank'], function(){
        Route::get('data', 'v1\BankController@data');
    });

//});

// Without Token
Route::post('pendaftar/approval', 'v1\PendaftaranController@approvalpeserta');
/**
     * Perusahaan
     */
    Route::group(['prefix' => 'perusahaan/'], function () {
        Route::post('add', 'v1\PerusahaanController@postperusahaan');
        Route::get('getperusahaan', 'v1\PerusahaanController@getperusahaan');
    });
