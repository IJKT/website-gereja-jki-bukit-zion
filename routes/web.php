<?php

// use App\Models\Jemaat;
// use App\Models\Pelayan;
// use App\Models\DataPelayan;

use App\Http\Controllers\DetailJadwalController;
use App\Http\Controllers\DetailLaguPujianController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalIbadahController;
use Illuminate\Support\Arr;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelayanController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\LaguPujianController;
use App\Http\Controllers\PembukuanController;
use App\Http\Controllers\PengajuanJemaatController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RangkumanFirmanController;
use App\Models\detail_lagu_pujian;
use App\Models\Pembukuan;
use App\Models\PengajuanJemaat;
use App\Models\Riwayat;


Route::get('/login', [HomeController::class, 'Login'])->name('login');
Route::post('/login/authenticate', [HomeController::class, 'LoginAuthenticate'])->name('login_authenticate');
Route::get('/logout', [HomeController::class, 'Logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('profil')
        ->name('Profil')
        ->group(
            function () {
                Route::get('', [ProfilController::class, 'profil'])->name('.profil');
                Route::get('/onreview', [ProfilController::class, 'profil_review'])->name('.profil_review');
                Route::put('update/{user}', [ProfilController::class, 'update'])->name('.update');
            }
        );

    Route::prefix('pengajuan')
        ->name('PengajuanJemaat')
        ->group(
            function () {
                Route::get('baptis', [PengajuanJemaatController::class, 'ViewBaptis'])->name('.baptis');
                Route::get('pernikahan', [PengajuanJemaatController::class, 'ViewPernikahan'])->name('.pernikahan');
                Route::get('baptis/tambah', [PengajuanJemaatController::class, 'TambahBaptis'])->name('.tambah_baptis');
                Route::get('baptis/{baptis}', [PengajuanJemaatController::class, 'UbahBaptis'])->name('.ubah_baptis');
                Route::get('pernikahan/{pernikahan}', [PengajuanJemaatController::class, 'TambahPernikahan'])->name('.tambah_pernikahan');
                Route::get('pernikahan/{pernikahan}', [PengajuanJemaatController::class, 'pernikahan'])->name('.ubah_pernikahan');
            }
        );



    Route::prefix('manajemen/pelayan')
        ->name('Manajemen.Pelayan')
        ->group(
            function () {
                Route::get('', [PelayanController::class, 'viewall'])->name('.viewall');
                Route::get('tambah', [PelayanController::class, 'tambah'])->name('.tambah');
                Route::get('search', [PelayanController::class, 'search'])->name('.search');
                Route::get('{pelayan}', [PelayanController::class, 'ubah'])->name('.ubah');
                Route::put('add', [PelayanController::class, 'add'])->name('.add');
                Route::put('update/{pelayan}', [PelayanController::class, 'update'])->name('.update');
                Route::put('status/{pelayan}', [PelayanController::class, 'status'])->name('.status');
            }
        );

    Route::prefix('manajemen/jemaat')
        ->name('Manajemen.Jemaat')
        ->group(
            function () {
                // MANAJEMEN JEMAAT
                Route::get('', [JemaatController::class, 'viewall'])->name('.viewall');
                Route::get('{jemaat}', [JemaatController::class, 'ubah'])->name('.ubah');
                Route::put('update/{jemaat}', [JemaatController::class, 'update'])->name('.update');
                Route::put('status/{jemaat}', [JemaatController::class, 'status'])->name('.status');
            }
        );
    Route::prefix('manajemen/pengajuan')
        ->name('Manajemen.Jemaat.Pengajuan')
        ->group(
            function () {
                //MANAJEMEN PENGAJUAN JEMAAT
                Route::get('', [JemaatController::class, 'pengajuanViewall'])->name('.viewall');
                Route::get('baptis/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifikasiBaptis'])->name('.verifikasi_baptis');
                Route::get('pernikahan/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifikasiPernikahan'])->name('.verifikasi_pernikahan');
                Route::get('registrasi/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifikasiRegistrasi'])->name('.verifikasi_registrasi');
                Route::put('verify/baptis/{baptis}', [JemaatController::class, 'pengajuanVerifyBaptis'])->name('.verify_baptis');
                Route::put('verify/pernikahan/{pernikahan}', [JemaatController::class, 'pengajuanVerifyPernikahan'])->name('.verify_pernikahan');
                Route::put('verify/registrasi/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifyRegistrasi'])->name('.verify_registrasi');
                Route::get('search', [JemaatController::class, 'search'])->name('.search');
            }
        );

    Route::get('/manajemen/riwayat', function () {
        return view(
            'Manajemen.riwayat',
            [
                'title' => 'Manajemen Riwayat',
                'riwayat' => Riwayat::with('pelayan.jemaat')->latest('tgl_perubahan')->paginate(5)
            ]
        );
    });
    Route::prefix('pembukuan')
        ->name('Pembukuan')
        ->group(
            function () {
                Route::get('', [PembukuanController::class, 'viewall'])->name('.viewall');
                Route::get('tambah', [PembukuanController::class, 'tambah'])->name('.tambah');
                Route::get('{pembukuan}', [PembukuanController::class, 'ubah'])->name('.ubah');
                Route::get('/verifikasi/{pembukuan}', [PembukuanController::class, 'verifikasi'])->name('.verifikasi');
                Route::put('add', [PembukuanController::class, 'add'])->name('.add');
                Route::put('update/{pembukuan}', [PembukuanController::class, 'update'])->name('.update');
                Route::put('verify/{pembukuan}', [PembukuanController::class, 'verify'])->name('.verify');
            }
        );

    Route::prefix('jadwal')
        ->name('Jadwal')
        ->group(
            function () {
                Route::get('', [JadwalIbadahController::class, 'viewall'])->name('.viewall');
                Route::get('tambah', [JadwalIbadahController::class, 'tambah'])->name('.tambah');
                Route::get('search-pendeta', [JadwalIbadahController::class, 'searchPendeta'])->name('.search-pendeta');
                Route::put('update/{jadwal}', [JadwalIbadahController::class, 'update'])->name('.update');
                Route::put('add', [JadwalIbadahController::class, 'add'])->name('.add');

                Route::get('search-multimedia', [JadwalIbadahController::class, 'searchMultimedia'])->name('.search-multimedia');
                Route::get('search-musik', [JadwalIbadahController::class, 'searchMusik'])->name('.search-musik');
                Route::get('search-pujian', [JadwalIbadahController::class, 'searchPujian'])->name('.search-pujian');


                // TODO: selesaikan buat yang pujian
                //DETAIL JADWAL
                Route::put('pelayan/add', [DetailJadwalController::class, 'AddPelayan'])->name('.AddPelayan');
                Route::put('pelayan/update', [DetailJadwalController::class, 'UpdatePelayan'])->name('.UpdatePelayan');
                Route::put('lagu/add', [DetailLaguPujianController::class, 'AddLagu'])->name('.AddLagu');
                Route::put('lagu/update', [DetailLaguPujianController::class, 'UpdateLagu'])->name('.UpdateLagu');


                Route::get('musik/ubah/{detail_jadwal}/{pelayan}', [DetailJadwalController::class, 'ubah_musik'])->name('.ubah_musik');
                Route::get('musik/tambah/{jadwal}', [DetailJadwalController::class, 'tambah_musik'])->name('.tambah_musik');
                Route::get('musik/{jadwal}', [DetailJadwalController::class, 'viewall_musik'])->name('.viewall_musik');

                Route::get('multimedia/ubah/{detail_jadwal}/{pelayan}', [DetailJadwalController::class, 'ubah_multimedia'])->name('.ubah_multimedia');
                Route::get('multimedia/tambah/{jadwal}', [DetailJadwalController::class, 'tambah_multimedia'])->name('.tambah_multimedia');
                Route::get('multimedia/{jadwal}', [DetailJadwalController::class, 'viewall_multimedia'])->name('.viewall_multimedia');

                Route::get('pujian/ubah/{detail_lagu}/{lagu}', [DetailLaguPujianController::class, 'ubah_pujian'])->name('.ubah_pujian');
                Route::get('pujian/tambah/{jadwal}', [DetailLaguPujianController::class, 'tambah_pujian'])->name('.tambah_pujian');
                Route::get('pujian/{jadwal}', [DetailJadwalController::class, 'viewall_pujian'])->name('.viewall_pujian');

                Route::get('{jadwal}', [JadwalIbadahController::class, 'ubah'])->name('.ubah');
            }
        );

    Route::prefix('sermons-articles')
        ->name('RangkumanFirman')
        ->group(
            function () {
                Route::get('', [RangkumanFirmanController::class, 'viewall'])->name('.viewall');
                Route::get('tambah', [RangkumanFirmanController::class, 'tambah'])->name('.tambah');
                Route::put('add', [RangkumanFirmanController::class, 'add'])->name('.add');
                Route::put('update/{rangkuman}', [RangkumanFirmanController::class, 'update'])->name('.update');

                Route::get('{rangkuman}', [RangkumanFirmanController::class, 'ubah'])->name('.ubah');
            }
        );

    Route::prefix('lagu')
        ->name('LaguPujian')
        ->group(
            function () {
                Route::get('', [LaguPujianController::class, 'viewall'])->name('.viewall');
                Route::get('tambah', [LaguPujianController::class, 'tambah'])->name('.tambah');
                Route::get('{lagu}', [LaguPujianController::class, 'ubah'])->name('.ubah');
                Route::put('update/{lagu}', [LaguPujianController::class, 'update'])->name('.update');
                Route::put('add', [LaguPujianController::class, 'add'])->name('.add');
            }
        );
});

Route::prefix('/')
    ->name('Home')
    ->group(
        function () {
            Route::get('', [HomeController::class, 'home'])->name('.home');
            Route::get('about', [HomeController::class, 'about'])->name('.about');

            Route::get('sermons', [HomeController::class, 'sermons'])->name('.sermons');
            Route::get('sermons/{kategori}', [HomeController::class, 'sermons_categories'])->name('.sermons_categories');

            Route::get('articles', [HomeController::class, 'articles'])->name('.articles');

            Route::get('devotions', [HomeController::class, 'devotions'])->name('.devotions');


            Route::get('register', [HomeController::class, 'register'])->name('.Akun.register');
            Route::post('register/authenticate', [HomeController::class, 'register_authenticate'])->name('.Akun.register_authenticate');
            Route::post('/cek-username', [HomeController::class, 'cekUsername'])->name('.cek.username');


            Route::get('{slug}', [HomeController::class, 'single_post'])->name('.single_post');
        }
    );
