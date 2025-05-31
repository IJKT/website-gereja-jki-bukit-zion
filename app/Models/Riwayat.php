<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $primaryKey = 'id_log';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_log',
        'id_pelayan_creator',
        'id_tabel_ubah',
        'jenis_perubahan',
        'tgl_perubahan',
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "PG{$datePart}";

        $lastRiwayat = self::where('id_log', 'like', "{$prefix}%")
            ->orderByDesc('id_log')
            ->first();

        if ($lastRiwayat) {
            $lastId = $lastRiwayat->id_log;
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
    public static function logChange($jenis_perubahan, $id_tabel_ubah = null, $id_pelayan_creator = null)
    {
        self::create([
            'id_log' => self::generateNextId(),
            'id_pelayan_creator' => $id_pelayan_creator ?? 'PL270525A1', // Replace with actual pelayan ID in real use
            'id_tabel_ubah' => $id_tabel_ubah,
            'jenis_perubahan' => $jenis_perubahan,
            'tgl_perubahan' => date("Y-m-d H:i:s"),
        ]);
    }

    // ALL THE RELATIONSHIPS
    public function pelayan(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pelayan_creator', 'id_pelayan');
    }
}
