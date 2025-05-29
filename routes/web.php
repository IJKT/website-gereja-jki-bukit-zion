<?php

// use App\Models\Jemaat;
// use App\Models\Pelayan;
// use App\Models\DataPelayan;
use Illuminate\Support\Arr;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelayanController;
use App\Http\Controllers\JemaatController;
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
            route::get('', [PelayanController::class, 'viewall'])->name('.viewall');
            // route::get('tambah', [PelayanController::class, 'tambah'])->name('.tambah');
            route::get('{pelayan}', [PelayanController::class, 'ubah']);
            // Route::put('add', [PelayanController::class, 'add'])->name('.add');
            // Route::put('update/{pelayan}', [PelayanController::class, 'ubah'])->name('.ubah');
        }
    );

Route::prefix('manajemen/jemaat')
    ->name('Manajemen.Jemaat')
    ->group(
        function () {
            // MANAJEMEN JEMAAT
            route::get('', [JemaatController::class, 'viewall'])->name('.viewall');
            // route::get('tambah', [JemaatController::class, 'tambah'])->name('.tambah');
            route::get('{jemaat}', [JemaatController::class, 'ubah'])->name('.ubah');
            // Route::put('add', [JemaatController::class, 'add'])->name('.add');
            // Route::put('update/{jemaat}', [JemaatController::class, 'update'])->name('.update');

            //TODO: bentuk buat view pengajuan jemaat
            //MANAJEMEN PENGAJUAN JEMAAT
            // route::get('pengajuan', [JemaatController::class, 'pengajuanViewall'])->name('.pengajuanViewall');
            // route::get('pengajuan/tambah', [JemaatController::class, 'pengajuanTambah'])->name('.pengajuanTambah');
            // route::get('pengajuan/{jemaat}', [JemaatController::class, 'pengajuanUbah'])->name('.pengajuanUbah');
            // Route::put('pengajuan/add', [JemaatController::class, 'pengajuanAdd'])->name('.pengajuanAdd');
            // Route::put('pengajuan/update/{jemaat}', [JemaatController::class, 'pengajuanUpdate'])->name('.pengajuanUpdate');
        }
    );

Route::get('/manajemen/riwayat', function () {
    return view(
        'Manajemen.riwayat',
        [
            'title' => 'Manajemen Riwayat',
            'riwayat' => Riwayat::with('pelayan.jemaat')->paginate(5)
        ]
    );
});

Route::prefix('pembukuan')
    ->name('Pembukuan')
    ->group(
        function () {
            route::get('', [PembukuanController::class, 'viewall'])->name('.viewall');
            route::get('tambah', [PembukuanController::class, 'tambah'])->name('.tambah');
            route::get('{pembukuan}', [PembukuanController::class, 'ubah'])->name('.ubah');
            Route::put('add', [PembukuanController::class, 'add'])->name('.add');
            Route::put('update/{pembukuan}', [PembukuanController::class, 'update'])->name('.update');
            // Route::put('verify/{pembukuan}', [PembukuanController::class, 'update'])->name('.verify');
        }
    );

Route::get('/jadwal', function () {
    return view(
        'jadwal',
        [
            'title' => 'Halaman Jadwal',
            'jadwal' => [
                [
                    'id' => "JI010125A1",
                    'tipe' => 'Shabbat Fellowship',
                    'tanggal' => '07-04-2025'
                ],
                [
                    'id' => "JI010125A2",
                    'tipe' => 'Sunday Service',
                    'tanggal' => '09-04-2025'
                ]
            ]
        ]
    );
});

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

Route::get('/lagu', function () {
    return view(
        'lagu',
        [
            'title' => 'Halaman Lagu Ibadah',
            'lagu' => [
                [
                    'id' => "LI020125A1",
                    'tipe' => 'Shabbat Fellowship',
                    'tanggal' => '07-04-2025'
                ],
                [
                    'id' => "LI020125A2",
                    'tipe' => 'Sunday Service',
                    'tanggal' => '09-04-2025'
                ]
            ]
        ]
    );
});



Route::get('/tes', function () {
    return view('tes');
});
