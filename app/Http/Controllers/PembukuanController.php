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
        $query = Pembukuan::query()->latest('tgl_pembukuan');

        // Filter by date range if both tanggal_awal and tanggal_akhir are present
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tgl_pembukuan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        } elseif ($request->filled('tanggal_awal')) {
            // If only tanggal_awal is present, filter from that date onwards
            $query->where('tgl_pembukuan', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            // If only tanggal_akhir is present, filter up to that date
            $query->where('tgl_pembukuan', '<=', $request->tanggal_akhir);
        }

        // Filter by jenis_pembukuan if present and not empty
        if ($request->filled('jenis_pembukuan')) {
            $query->where('jenis_pembukuan', $request->jenis_pembukuan);
        }

        return view(
            'Pembukuan.viewall',
            [
                'title' => 'Halaman Pembukuan',
                'pembukuan' => $query->paginate(5)->withQueryString()
            ]
        );
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
        // Ambil awal dan akhir bulan ini
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $pembukuan = Pembukuan::whereBetween('tgl_pembukuan', [$startOfMonth, $endOfMonth])
            ->orderBy('tgl_pembukuan')
            ->get();

        $total_pemasukan = $pembukuan->where('jenis_pembukuan', 'Uang Masuk')->sum('nominal_pembukuan');
        $total_pengeluaran = $pembukuan->where('jenis_pembukuan', 'Uang Keluar')->sum('nominal_pembukuan');

        $pdf = Pdf::loadView('Exports.pembukuan_file', [
            'pembukuan' => $pembukuan,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'total_simpanan' => $total_pemasukan - $total_pengeluaran,
        ]);

        return $pdf->download('Laporan_Pembukuan_Bulan_Ini.pdf');
    }

    public function add(Request $request)
    {
        $pembukuan = new Pembukuan();
        $pembukuan->id_pembukuan = $request->id_pembukuan;
        $pembukuan->jenis_pembukuan = $request->jenis_pembukuan;
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
            'deskripsi_pembukuan' => ['nullable', 'string'],
        ]);

        // Remove commas from nominal_pembukuan and convert to integer
        $nominal = (int) str_replace(',', '', $validated['nominal_pembukuan']);

        // Update the Pembukuan record
        $pembukuan->update([
            'nominal_pembukuan'   => $nominal,
            'jenis_pembukuan'     => $validated['jenis_pembukuan'],
            'tgl_pembukuan'     => $validated['tgl_pembukuan'],
            'deskripsi_pembukuan' => $validated['deskripsi_pembukuan'],
            'verifikasi_pembukuan' => 0,
        ]);

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
