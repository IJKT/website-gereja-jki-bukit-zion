<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jemaat;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PengajuanJemaat;
use App\Models\rangkuman_firman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(): View
    {
        return view('Home.home', [
            'title' => "Halaman Home",
        ]);
    }
    public function about(): View
    {
        return view(
            'Home.about',
            ['nama' => "Ivan S. Tjahja"],
            ['title' => "Halaman About"]
        );
    }
    public function sermons(): View
    {
        return view('Home.posts', [
            'title' => "Halaman Sermons",
            'rangkuman' => rangkuman_firman::latest('tgl_rangkuman')
                ->where('tipe_rangkuman', 'like', 'Sermons')
                ->paginate(10)
        ]);
    }
    public function articles(): View
    {
        return view('Home.posts', [
            'title' => "Halaman Articles",
            'rangkuman' => rangkuman_firman::latest('tgl_rangkuman')
                ->where('tipe_rangkuman', 'like', 'Articles')
                ->paginate(10)
        ]);
    }
    public function devotions(): View
    {
        return view('Home.posts', [
            'title' => "Halaman Sermons",
            'rangkuman' => rangkuman_firman::latest('tgl_rangkuman')
                ->where('tipe_rangkuman', 'like', 'Devotions')
                ->paginate(10)
        ]);
    }
    public function sermons_categories(String $kategori): View
    {
        return view('Home.posts', [
            'title' => "Halaman Sermons",
            'rangkuman' => rangkuman_firman::latest('tgl_rangkuman')
                ->where('kategori_sermons', 'like', $kategori)
                ->paginate(10)
        ]);
    }
    public function single_post(String $slug): View
    {
        $rangkuman = rangkuman_firman::where('slug_rangkuman', $slug)->firstOrFail();
        return view('Home.post', [
            'title' => $rangkuman->judul_rangkuman,
            'rangkuman' => $rangkuman
        ]);
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('Profil.profil');
        }
        return view('Home.Akun.login', ['title' => "Halaman Login"]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('Home.home');
    }
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('Profil.profil');
        }
        return view('Home.Akun.register', ['title' => "Halaman Register"]);
    }
    public function login_authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('Profil.profil'));
        } else {
            return redirect()->back()->with('gagal', 'Username atau password anda salah');
        };
    }
    public function cekUsername(Request $request)
    {
        $exists = DB::table('users')->where('username', $request->username)->exists();
        return response()->json(['exists' => $exists]);
    }
    public function register_authenticate(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        $id_jemaat = Jemaat::generateNextId();
        $jemaat = new Jemaat();
        $jemaat->id_jemaat = $id_jemaat;
        $jemaat->username = $request->username;
        $jemaat->nama_jemaat = $request->nama_lengkap;
        $jemaat->jk_jemaat = $request->gender;
        $jemaat->nik_jemaat = $request->nik;
        $jemaat->tmpt_lahir_jemaat = $request->tempat_lahir;
        $jemaat->tgl_lahir_jemaat = $request->tgl_lahir;
        $jemaat->tgl_daftar_jemaat = now();
        $jemaat->telp_jemaat = $request->telepon;
        $jemaat->email_jemaat = $request->email;
        $jemaat->alamat_jemaat = $request->alamat;
        $jemaat->save();

        $pengajuan = new PengajuanJemaat();
        $pengajuan->id_pengajuan = PengajuanJemaat::generateNextId();
        $pengajuan->id_jemaat = $id_jemaat;
        $pengajuan->jenis_pengajuan = 'Registrasi';
        $pengajuan->tanggal_pengajuan = now();
        $pengajuan->save();

        return redirect()->route('login');
    }
}
