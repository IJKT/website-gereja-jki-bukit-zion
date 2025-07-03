<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelayan extends Model
{
    use HasFactory;

    protected $table = 'pelayan';
    protected $primaryKey = 'id_pelayan';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pelayan',
        'id_jemaat',
        'hak_akses_pelayan',
        'status_pelayan'
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "PL{$datePart}";

        $lastPelayan = self::where('id_pelayan', 'like', "{$prefix}%")
            ->orderByDesc('id_pelayan')
            ->first();

        if ($lastPelayan) {
            $lastId = $lastPelayan->id_pelayan;
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

    public function jemaat(): BelongsTo
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }
    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'id_pelayan', 'id_pelayan_creator');
    }
    public function baptis(): HasMany
    {
        return $this->hasMany(Baptis::class, 'id_pembaptis', 'id_pelayan');
    }
    public function pernikahan(): HasMany
    {
        return $this->hasMany(Pernikahan::class, 'id_pendeta', 'id_pelayan');
    }
    public function detail_jadwal(): HasMany
    {
        return $this->hasMany(detail_jadwal::class, 'id_pelayan', 'id_pelayan');
    }
    public function RevisiPengajuan(): HasMany
    {
        return $this->HasMany(RevisiPengajuan::class, 'id_pengomentar', 'id_pelayan');
    }
}
