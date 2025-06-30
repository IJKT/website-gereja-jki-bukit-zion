<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Riwayat;
use App\Models\Pembukuan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PembukuanController extends Controller
{
    public function viewall(Request $request): View
    {
        // =============== Query terfilter untuk list & subtotal ===============
        $query = Pembukuan::query()->OrderBy('verifikasi_pembukuan');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tgl_pembukuan', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->where('tgl_pembukuan', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->where('tgl_pembukuan', '<=', $request->tanggal_akhir);
        } else {
            $query->whereBetween('tgl_pembukuan', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        }

        if ($request->filled('jenis_pembukuan')) {
            $query->where('jenis_pembukuan', $request->jenis_pembukuan);
        }

        // ✅ Paginate yang terfilter
        $pembukuan = (clone $query)->latest('tgl_pembukuan')->paginate(5)->withQueryString();

        // ✅ Total pemasukan & pengeluaran hanya untuk data terfilter
        $resultFiltered = (clone $query)
            ->selectRaw("
        SUM(CASE WHEN jenis_pembukuan = 'Uang Masuk' AND verifikasi_pembukuan = 1 THEN nominal_pembukuan ELSE 0 END) as total_pemasukan,
        SUM(CASE WHEN jenis_pembukuan = 'Uang Keluar' AND verifikasi_pembukuan = 1 THEN nominal_pembukuan ELSE 0 END) as total_pengeluaran")
            ->first();

        $total_pemasukan = $resultFiltered->total_pemasukan ?? 0;
        $total_pengeluaran = $resultFiltered->total_pengeluaran ?? 0;

        // =============== Query tanpa filter untuk saldo akhir ===============
        $resultAll = Pembukuan::where('verifikasi_pembukuan', 1)
            ->selectRaw("
            SUM(CASE WHEN jenis_pembukuan = 'Uang Masuk' THEN nominal_pembukuan ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN jenis_pembukuan = 'Uang Keluar' THEN nominal_pembukuan ELSE 0 END) as total_pengeluaran")
            ->first();

        $total_semua_pemasukan = $resultAll->total_pemasukan ?? 0;
        $total_semua_pengeluaran = $resultAll->total_pengeluaran ?? 0;
        $total_sisa = $total_semua_pemasukan - $total_semua_pengeluaran;

        // Label dinamis
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $label_periode = 'PEMBUKUAN '
                . Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y')
                . ' - '
                . Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
        } elseif ($request->filled('tanggal_awal')) {
            $label_periode = 'PEMBUKUAN MULAI '
                . Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y');
        } elseif ($request->filled('tanggal_akhir')) {
            $label_periode = 'PEMBUKUAN SAMPAI '
                . Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
        } else {
            $label_periode = 'PEMBUKUAN ' . Carbon::now()->translatedFormat('F Y');
        }

        return view('Pembukuan.viewall', [
            'title' => 'Halaman Pembukuan',
            'pembukuan' => $pembukuan,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'total_sisa' => $total_sisa,
            'label_periode' => $label_periode,
        ]);
    }

    public function ubah(Pembukuan $pembukuan): View
    {
        return view(
            'Pembukuan.ubah',
            [
                'title' => 'Ubah Data Pembukuan',
                'pembukuan' => $pembukuan
            ]
        );
    }
    public function verifikasi(Pembukuan $pembukuan): View
    {
        return view(
            'Pembukuan.verifikasi',
            [
                'title' => 'Verifikasi Data Pembukuan',
                'pembukuan' => $pembukuan
            ]
        );
    }
    public function tambah(): View
    {
        $id_pembukuan = Pembukuan::generateNextId();

        return view(
            'Pembukuan.tambah',
            [
                'title' => 'Tambah Data Pembukuan',
                'id_pembukuan' => $id_pembukuan
            ]
        );
    }
    public function unduh(Request $request)
    {
        // Query dasar: hanya yang sudah diverifikasi
        $query = Pembukuan::where('verifikasi_pembukuan', 1);

        // Filter tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tgl_pembukuan', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->where('tgl_pembukuan', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->where('tgl_pembukuan', '<=', $request->tanggal_akhir);
        } else {
            // Default: bulan ini
            $query->whereBetween('tgl_pembukuan', [
                Carbon::now()->startOfMonth()->toDateString(),
                Carbon::now()->endOfMonth()->toDateString()
            ]);
        }

        // Filter jenis_pembukuan jika diisi
        if ($request->filled('jenis_pembukuan')) {
            $query->where('jenis_pembukuan', $request->jenis_pembukuan);
        }

        // Ambil hasil
        $pembukuan = $query->orderBy('tgl_pembukuan')->get();

        // Hitung subtotal (hanya data terfilter)
        $total_pemasukan = $pembukuan->where('jenis_pembukuan', 'Uang Masuk')->sum('nominal_pembukuan');
        $total_pengeluaran = $pembukuan->where('jenis_pembukuan', 'Uang Keluar')->sum('nominal_pembukuan');

        // Hitung saldo total (semua data terverifikasi - tidak terfilter)
        $resultAll = Pembukuan::where('verifikasi_pembukuan', 1)
            ->selectRaw("
            SUM(CASE WHEN jenis_pembukuan = 'Uang Masuk' THEN nominal_pembukuan ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN jenis_pembukuan = 'Uang Keluar' THEN nominal_pembukuan ELSE 0 END) as total_pengeluaran
        ")->first();

        $total_semua_pemasukan = $resultAll->total_pemasukan ?? 0;
        $total_semua_pengeluaran = $resultAll->total_pengeluaran ?? 0;
        $total_sisa = $total_semua_pemasukan - $total_semua_pengeluaran;

        // Buat label periode
        Carbon::setLocale('id');
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $label_periode = 'Laporan Pembukuan '
                . Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y')
                . ' - '
                . Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
        } elseif ($request->filled('tanggal_awal')) {
            $label_periode = 'Laporan Pembukuan mulai '
                . Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y');
        } elseif ($request->filled('tanggal_akhir')) {
            $label_periode = 'Laporan Pembukuan sampai '
                . Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
        } else {
            $label_periode = 'Laporan Pembukuan ' . Carbon::now()->translatedFormat('F Y');
        }

        // Generate PDF
        $pdf = Pdf::loadView('Exports.pembukuan_file', [
            'pembukuan' => $pembukuan,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'total_sisa' => $total_sisa,
            'label_periode' => $label_periode
        ]);

        return $pdf->download('Laporan Pembukuan JKI Bukit Zion.pdf');
    }


    public function add(Request $request)
    {
        $pembukuan = new Pembukuan();
        $pembukuan->id_pembukuan = $request->id_pembukuan;
        $pembukuan->jenis_pembukuan = $request->jenis_pembukuan;
        $pembukuan->jenis_pemasukan = $request->jenis_pemasukan;
        $pembukuan->nominal_pembukuan = $request->nominal_pembukuan;
        $pembukuan->tgl_pembukuan = $request->tgl_pembukuan;
        $pembukuan->deskripsi_pembukuan = $request->deskripsi_pembukuan;
        $pembukuan->save();

        Riwayat::logChange(1, $request->id_pembukuan, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('Pembukuan.viewall');
    }
    public function update(Request $request, Pembukuan $pembukuan)
    {
        // Validate input
        $validated = $request->validate([
            'nominal_pembukuan'   => ['required', 'string'],
            'tgl_pembukuan'   => ['required', 'date'],
            'jenis_pembukuan'     => ['required', 'in:Uang Masuk,Uang Keluar'],
            'deskripsi_pembukuan' => ['required', 'string'],
            'jenis_pemasukan' => ['nullable', 'in:Persembahan Ibadah Raya,Persembahan Perpuluhan,Persembahan Misi,Persembahan Outreach,Persembahan Rumah Asuhan,Persembahan Donasi'],
        ]);

        // Remove commas from nominal_pembukuan and convert to integer
        $nominal = (int) str_replace(',', '', $validated['nominal_pembukuan']);


        // dd($validated['jenis_pemasukan']);

        // Update the Pembukuan record
        $pembukuan->nominal_pembukuan = $nominal;
        $pembukuan->jenis_pembukuan = $validated['jenis_pembukuan'];
        $pembukuan->jenis_pemasukan = $validated['jenis_pembukuan'] === 'Uang Masuk' ? $validated['jenis_pemasukan'] : null;
        $pembukuan->tgl_pembukuan = $validated['tgl_pembukuan'];
        $pembukuan->deskripsi_pembukuan = $validated['deskripsi_pembukuan'];
        $pembukuan->verifikasi_pembukuan = 0;

        $pembukuan->save();



        Riwayat::logChange(2, $pembukuan->id_pembukuan, Auth::user()->jemaat->pelayan->id_pelayan);
        // Redirect back with a success message
        return redirect()->route('Pembukuan.viewall');
    }
    public function verify(Request $request, Pembukuan $pembukuan)
    {
        $validated = $request->validate([
            'catatan_pembukuan' => ['nullable', 'string'],
            'verifikasi_pembukuan' => ['required', 'in:1, 2'],
        ]);
        // Update the Pembukuan record
        $pembukuan->update([
            'catatan_pembukuan' => $validated['catatan_pembukuan'],
            'verifikasi_pembukuan' => $validated['verifikasi_pembukuan']
        ]);

        if ($request->verifikasi_pembukuan == 1) {
            // apabila verifikasi diterima
            Riwayat::logChange(4, $pembukuan->id_pembukuan, Auth::user()->jemaat->pelayan->id_pelayan);
        } else {
            // apabila verifikasi ditolak
            // TODO: tambahkan alasan penolakan di detail riwayat
            Riwayat::logChange(5, $pembukuan->id_pembukuan, Auth::user()->jemaat->pelayan->id_pelayan);
        }
        // Redirect back with a success message
        return redirect()->route('Pembukuan.viewall');
    }
}
