<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jemaat;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\ResetPasswordMail;
use App\Models\Kontak;
use App\Models\PengajuanJemaat;
use App\Models\rangkuman_firman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class   HomeController extends Controller
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
    public function Contact(): View
    {
        return view('Home.contacts', [
            'title' => "Halaman Kontak",
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

    public function ContactSend(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'category' => 'required|string',
            'message' => 'required|string',
        ]);

        $contact_send = new Kontak();
        $contact_send->id_kontak = Kontak::generateNextId();
        $contact_send->nama = $validated['name'];
        $contact_send->email = $validated['email'];
        $contact_send->kategori = $validated['category'];
        $contact_send->pesan = $validated['message'];
        $contact_send->save();

        return back()->with('success', 'Pesan Anda berhasil dikirim!');
    }

    // AUTHENTICATION
    public function Login()
    {
        if (Auth::check()) {
            return redirect()->route('Profil.profil');
        }
        return view('Home.Akun.login', ['title' => "Halaman Login"]);
    }
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('Profil.profil');
        }
        return view('Home.Akun.register', ['title' => "Halaman Register"]);
    }
    public function Logout()
    {
        Auth::logout();
        return redirect()->route('Home.home');
    }
    public function LoginAuthenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('Dashboard.index'));
        } else {
            return redirect()->back()->with('gagal', 'Username atau password anda salah');
        };
    }
    public function cekUsername(Request $request)
    {
        $exists = User::where('username', $request->username)->exists();
        return response()->json(['exists' => $exists]);
    }
    public function cekEmail(Request $request)
    {
        $exists = Jemaat::where('email_jemaat', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function register_authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
        ]);
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

    // RESET PASSWORD
    public function ForgotPassword()
    {
        if (Auth::check()) {
            return redirect()->route('Profil.profil');
        }
        return view('Home.Akun.forgot_password', ['title' => "Lupa Password"]);
    }
    public function ForgotPasswordAuthenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:jemaat,email_jemaat',
        ]);

        $token = Str::random(60);
        $email = $request->email;

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );

        // Misalnya kamu ingin pakai Mail (bisa disesuaikan nanti)
        $resetLink = url("/reset-password/{$token}");

        // Contoh pengiriman via Laravel Mail (jika tidak pakai Mail, cukup dd link dulu)
        Mail::to($email)->send(new ResetPasswordMail($resetLink));


        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }
    public function ResetPassword($token)
    {
        if (Auth::check()) {
            return redirect()->route('Profil.profil');
        }
        return view('Home.Akun.reset_password', ['title' => "Reset Password", 'token' => $token]);
    }
    public function ResetPasswordAuthenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:jemaat,email_jemaat',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['token' => 'Token tidak valid atau kadaluarsa.']);
        }

        $jemaat = Jemaat::where('email_jemaat', $request->email)->first();
        if (!$jemaat) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user = User::where('username', $jemaat->username)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil direset.');
    }
}
