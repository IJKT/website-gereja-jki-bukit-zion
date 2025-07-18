<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Jemaat;
use App\Models\Pelayan;
use Illuminate\View\View;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use App\Models\PengajuanJemaat;
use App\Models\RevisiPengajuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class  PengajuanJemaatController extends Controller
{
    public function ViewBaptis(): View
    {
        $data_baptis = PengajuanJemaat::where('id_jemaat', Auth::user()->jemaat->id_jemaat)->where('jenis_pengajuan', 'Baptis')->first();
        if ($data_baptis != null) {
            $data_revisi = RevisiPengajuan::where('id_revisi', $data_baptis->id_pengajuan)->orderByDesc('tgl_revisi')->paginate(3);
            $detail_baptis = Baptis::where('id_baptis', $data_baptis->id_pengajuan)->first();
        }

        return view('PengajuanJemaat.baptis', [
            'title' => "Pengajuan Baptis",
            'data_baptis' => $data_baptis,
            'detail_baptis' => $detail_baptis ?? null,
            'data_revisi' => $data_revisi ?? null,
        ]);
    }
    public function ViewPernikahan(): View
    {
        $jemaat = Auth::user()->jemaat;
        $pasangan = $jemaat->pasangan();

        $idSendiri = $jemaat->id_jemaat;
        $idPasangan = $pasangan?->id_jemaat;

        // Cek apakah ada pengajuan dari diri sendiri atau pasangan
        $data_pernikahan = PengajuanJemaat::where('jenis_pengajuan', 'Pernikahan')
            ->where(function ($query) use ($idSendiri, $idPasangan) {
                $query->where('id_jemaat', $idSendiri);
                if ($idPasangan) {
                    $query->orWhere('id_jemaat', $idPasangan);
                }
            })
            ->first();

        if ($data_pernikahan != null) {
            $detail_pernikahan = Pernikahan::where('id_pernikahan', $data_pernikahan->id_pengajuan)->first();
            $data_revisi = RevisiPengajuan::where('id_revisi', $data_pernikahan->id_pengajuan)->orderByDesc('tgl_revisi')->paginate(3);
        }

        return view('PengajuanJemaat.pernikahan', [
            'title' => "Pengajuan Pernikahan",
            'data_pernikahan' => $data_pernikahan,
            'detail_pernikahan' => $detail_pernikahan ?? null,
            'data_revisi' => $data_revisi ?? null,
            'pasangan' => $pasangan,
        ]);
    }

    public function TambahBaptis(): View
    {
        return view('PengajuanJemaat.tambah_baptis', [
            'title' => "Tambah Pengajuan Baptis",
            'id_baptis' => PengajuanJemaat::generateNextId(),
        ]);
    }
    public function TambahPernikahan(): View
    {
        return view('PengajuanJemaat.tambah_pernikahan', [
            'title' => "Tambah Pengajuan Pernikahan",
            'id_pernikahan' => PengajuanJemaat::generateNextId(),
        ]);
    }

    public function UbahBaptis(Baptis $baptis): View
    {
        return view('PengajuanJemaat.ubah_baptis', [
            'title' => 'Ubah Pengajuan Baptis',
            'baptis' => $baptis
        ]);
    }
    public function UbahPernikahan(Pernikahan $pernikahan): View
    {
        return view('PengajuanJemaat.ubah_pernikahan', [
            'title' => 'Ubah Pengajuan Pernikahan',
            // 'jenis_kelamin' => Auth::user(),
            'pernikahan' => $pernikahan,
        ]);
    }

    public function AddBaptis(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'akta' => 'nullable|file|mimes:pdf',
        ]);
        $id_pengajuan = PengajuanJemaat::generateNextId();
        // tambah pengajuan jemaat
        $pengajuanjemaat = new PengajuanJemaat();
        $pengajuanjemaat->id_pengajuan = $id_pengajuan;
        $pengajuanjemaat->id_jemaat = Auth::user()->jemaat->id_jemaat;
        $pengajuanjemaat->jenis_pengajuan = 'Baptis';
        $pengajuanjemaat->tanggal_pengajuan = now();
        $pengajuanjemaat->save();

        // tambah baptis
        $baptis = new Baptis();
        $baptis->id_baptis = $id_pengajuan;
        $baptis->preferensi_nama_baptis = $request->preferensi_nama;
        $baptis->id_pengajar = $request->id_pelayan;
        $baptis->save();

        return redirect()->route('PengajuanJemaat.baptis');
    }
    public function AddPernikahan(Request $request)
    {
        $jemaat = Auth::user()->jemaat;
        $id_pasangan = $request->id_jemaat;

        // buat id pengajuan baru
        $id_pengajuan = PengajuanJemaat::generateNextId();
        // tambah pengajuan jemaat
        $pengajuanjemaat = new PengajuanJemaat();
        $pengajuanjemaat->id_pengajuan = $id_pengajuan;
        $pengajuanjemaat->id_jemaat = Auth::user()->jemaat->id_jemaat;
        $pengajuanjemaat->jenis_pengajuan = 'Pernikahan';
        $pengajuanjemaat->tanggal_pengajuan = now();
        $pengajuanjemaat->save();

        // tambah pernikahan
        $pernikahan = new Pernikahan();
        $pernikahan->id_pernikahan = $id_pengajuan;
        // Cek jenis kelamin untuk menentukan pria/wanita
        if ($jemaat->jk_jemaat === 'P') {
            $pernikahan->id_jemaat_p = $jemaat->id_jemaat;
            $pernikahan->id_jemaat_w = $id_pasangan;
        } else {
            $pernikahan->id_jemaat_p = $id_pasangan;
            $pernikahan->id_jemaat_w = $jemaat->id_jemaat;
        }
        $pernikahan->tgl_pernikahan = $request->tanggal_jam_pernikahan;
        $pernikahan->tempat_pernikahan = $request->tempat_pernikahan;
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $originalName = $file->getClientOriginalName();
            $targetDir = 'pernikahan';

            // Prevent filename collisions by prefixing with a timestamp if file exists
            $storagePath = storage_path("app/public/{$targetDir}/{$originalName}");
            if (file_exists($storagePath)) {
                $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $originalName = $filenameWithoutExt . '_' . time() . '.' . $extension;
            }

            // Store the file with its (possibly modified) original name
            $path = $file->storeAs($targetDir, $originalName, 'public');
            $pernikahan->berkas_pernikahan = $path; // Save the relative path as a string
        }
        $pernikahan->save();

        return redirect()->route('PengajuanJemaat.pernikahan');
    }

    public function UpdateBaptis(Request $request, Baptis $baptis)
    {
        // Update data baptis
        $baptis->preferensi_nama_baptis = $request->preferensi_nama;
        $baptis->id_pengajar = $request->id_pelayan;
        $baptis->save();

        // Mengembalikan verifikasi pengajuan ke 0 (Menunggu Verifikasi)
        $pengajuanjemaat = PengajuanJemaat::where('id_pengajuan', $baptis->id_baptis)->first();
        $pengajuanjemaat->verifikasi_pengajuan = 0;
        $pengajuanjemaat->save();

        return redirect()->route('PengajuanJemaat.baptis');
    }
    public function UpdatePernikahan(Request $request, Pernikahan $pernikahan)
    {
        // dd($request->all());
        $jemaat = Auth::user()->jemaat;
        $id_pasangan = $request->id_jemaat;

        // ubah pernikahan
        // Cek jenis kelamin untuk menentukan pria/wanita
        if ($jemaat->jk_jemaat === 'P') {
            $pernikahan->id_jemaat_p = $jemaat->id_jemaat;
            $pernikahan->id_jemaat_w = $id_pasangan;
        } else {
            $pernikahan->id_jemaat_p = $id_pasangan;
            $pernikahan->id_jemaat_w = $jemaat->id_jemaat;
        }
        $pernikahan->tgl_pernikahan = $request->tanggal_jam_pernikahan;
        $pernikahan->tempat_pernikahan = $request->tempat_pernikahan;
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $originalName = $file->getClientOriginalName();
            $targetDir = 'pernikahan';

            // Prevent filename collisions by prefixing with a timestamp if file exists
            $storagePath = storage_path("app/public/{$targetDir}/{$originalName}");
            if (file_exists($storagePath)) {
                $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $originalName = $filenameWithoutExt . '_' . time() . '.' . $extension;
            }

            // Store the file with its (possibly modified) original name
            $path = $file->storeAs($targetDir, $originalName, 'public');
            $pernikahan->berkas_pernikahan = $path; // Save the relative path as a string
        }
        $pernikahan->save();

        $pengajuanjemaat = PengajuanJemaat::where('id_pengajuan', $pernikahan->id_pernikahan)->first();
        $pengajuanjemaat->verifikasi_pengajuan = 0;
        $pengajuanjemaat->save();

        return redirect()->route('PengajuanJemaat.pernikahan');
    }

    //ETC
    public function SearchPengajar(Request $request)
    {
        $query = $request->get('q');

        $results = Pelayan::join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->where('jemaat.nama_jemaat', 'like', "%$query%")
            ->select('pelayan.id_pelayan', 'jemaat.nama_jemaat as nama_pengajar')
            ->get();

        return response()->json($results);
    }
    public function SearchPasangan(Request $request)
    {
        $query = $request->get('q');
        $excludeGender = $request->get('exclude_gender');

        // Ambil semua id jemaat yang sudah terdaftar di pernikahan
        $sudahMenikahIds = DB::table('pernikahan')
            ->select('id_jemaat_p as id_jemaat')
            ->union(
                DB::table('pernikahan')->select('id_jemaat_w as id_jemaat')
            )
            ->pluck('id_jemaat');

        $results = Jemaat::where('nama_jemaat', 'like', "%$query%")
            ->when($excludeGender, function ($query, $excludeGender) {
                $oppositeGender = $excludeGender === 'P' ? 'W' : 'P';
                $query->where('jk_jemaat', $oppositeGender);
            })
            ->whereNotIn('id_jemaat', $sudahMenikahIds) // Hindari jemaat yang sudah menikah
            ->select('id_jemaat', 'nama_jemaat as nama_pasangan')
            ->get();

        return response()->json($results);
    }
}
