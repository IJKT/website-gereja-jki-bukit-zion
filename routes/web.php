<?php

// use App\Models\Jemaat;
// use App\Models\Pelayan;
// use App\Models\DataPelayan;

use App\Http\Controllers\DetailJadwalController;
use App\Http\Controllers\JadwalIbadahController;
use Illuminate\Support\Arr;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelayanController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\LaguPujianController;
use App\Http\Controllers\PembukuanController;
use App\Models\Pembukuan;
use App\Models\Riwayat;

Route::get('/', function () {
    return view('Home.home', ['title' => "Halaman Home"]);
});

Route::get('/about', function () {
    return view(
        'Home.about',
        ['nama' => "Ivan S. Tjahja"],
        ['title' => "Halaman About"]
    );
});

Route::get('/login', function () {
    return view('Akun.login', ['title' => "Halaman Login"]);
});
Route::get('/register', function () {
    return view('Akun.register', ['title' => "Halaman Register"]);
});

Route::get('/profil', function () {
    return view(
        'profile',
        [
            'title' => "Halaman Profil",
            'nama_lengkap' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'nik' => '1234567890',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '01-01-2025',
            'alamat' => 'Jl. Lorem Ipsum no. 1',
            'jenis_kelamin' => 'P',
            'nomor_hp' => '081234567890'
        ]
    );
});

Route::get('/pengajuan/baptis', function () {
    return view(
        'submission_baptis',
        ['title' => "Pengajuan Baptis"]
    );
});

Route::get('/pengajuan/pernikahan', function () {
    return view(
        'submission_marriage',
        ['title' => "Pengajuan Pernikahan"]
    );
});


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
            // Route::get('pengajuan/tambah', [JemaatController::class, 'pengajuanTambah'])->name('.Pengajuan.tambah');
            Route::get('baptis/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifikasiBaptis'])->name('.verifikasi_baptis');
            Route::get('pernikahan/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifikasiPernikahan'])->name('.verifikasi_pernikahan');
            Route::get('registrasi/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifikasiRegistrasi'])->name('.verifikasi_registrasi');
            Route::get('search', [JemaatController::class, 'search'])->name('.search');
            Route::put('verify/baptis/{baptis}', [JemaatController::class, 'pengajuanVerifyBaptis'])->name('.verify_baptis');
            Route::put('verify/pernikahan/{pernikahan}', [JemaatController::class, 'pengajuanVerifyPernikahan'])->name('.verify_pernikahan');
            Route::put('verify/registrasi/{pengajuan_jemaat}', [JemaatController::class, 'pengajuanVerifyRegistrasi'])->name('.verify_registrasi');
            // Route::put('pengajuan/add', [JemaatController::class, 'pengajuanAdd'])->name('.Pengajuan.add');
            // Route::put('pengajuan/update/{jemaat}', [JemaatController::class, 'pengajuanUpdate'])->name('.Pengajuan.update');
        }
    );
// Route::get('manajemen/jemaat/pengajuan', function () {
//     return view(
//         'Manajemen.riwayat'
//     );
// });

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
            Route::get('search-multimedia', [JadwalIbadahController::class, 'searchMultimedia'])->name('.search-multimedia');
            Route::get('search-musik', [JadwalIbadahController::class, 'searchMusik'])->name('.search-musik');
            Route::put('update/{jadwal}', [JadwalIbadahController::class, 'update'])->name('.update');
            Route::put('add', [JadwalIbadahController::class, 'add'])->name('.add');


            // TODO: selesaikan buat yang pujian
            //DETAIL JADWAL
            Route::put('pelayan/add', [DetailJadwalController::class, 'AddPelayan'])->name('.AddPelayan');
            Route::put('pelayan/update', [DetailJadwalController::class, 'UpdatePelayan'])->name('.UpdatePelayan');
            Route::get('musik/ubah/{detail_jadwal}/{pelayan}', [DetailJadwalController::class, 'ubah_musik'])->name('.ubah_musik');
            Route::get('musik/tambah/{jadwal}', [DetailJadwalController::class, 'tambah_musik'])->name('.tambah_musik');
            Route::get('musik/{jadwal}', [DetailJadwalController::class, 'viewall_musik'])->name('.viewall_musik');
            Route::get('multimedia/ubah/{detail_jadwal}/{pelayan}', [DetailJadwalController::class, 'ubah_multimedia'])->name('.ubah_multimedia');
            Route::get('multimedia/tambah/{jadwal}', [DetailJadwalController::class, 'tambah_multimedia'])->name('.tambah_multimedia');
            Route::get('multimedia/{jadwal}', [DetailJadwalController::class, 'viewall_multimedia'])->name('.viewall_multimedia');
            Route::get('pujian/{jadwal}', [DetailJadwalController::class, 'viewall_pujian'])->name('.viewall_pujian');


            Route::get('{jadwal}', [JadwalIbadahController::class, 'ubah'])->name('.ubah');
        }
    );

Route::get('/sermons-articles', function () {
    return view(
        'sermons_articles',
        [
            'title' => 'Halaman Rangkuman Firman',
            'rangkuman' => [
                [
                    'id' => "RF040325A1",
                    'judul' => 'Sermon Name',
                    'tipe' => 'Sermons'
                ],
                [
                    'id' => "RF040325A2",
                    'judul' => 'Article Name',
                    'tipe' => 'Articles'
                ]
            ]
        ]
    );
});

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
