<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembukuan extends Model
{
    /** @use HasFactory<\Database\Factories\PembukuanFactory> */
    use HasFactory;
    protected $table = 'pembukuan';
    protected $primaryKey = 'id_pembukuan';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pembukuan',
        'jenis_pembukuan',
        'nominal_pembukuan',
        'tgl_pembukuan',
        'deskripsi_pembukuan',
        'verifikasi_pembukuan',
        'catatan_pembukuan'
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "PG{$datePart}";

        $lastPembukuan = self::where('id_pembukuan', 'like', "{$prefix}%")
            ->orderByDesc('id_pembukuan')
            ->first();

        if ($lastPembukuan) {
            $lastId = $lastPembukuan->id_pembukuan;
            $suffix = substr($lastId, strlen($prefix));
            $letter = substr($suffix, 0, 1);
            $number = intval(substr($suffix, 1));
            if ($number < 9) {
                $number++;
            } else {
                $number = 1;
                $letter = chr(ord($letter) + 1);
            }
        } else {
            $letter = 'A';
            $number = 1;
        }

        $newSuffix = "{$letter}{$number}";
        return "{$prefix}{$newSuffix}";
    }
}
