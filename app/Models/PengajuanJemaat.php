<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengajuanJemaat extends Model
{
    // use HasFactory;
    protected $table = 'pengajuan_jemaat';
    protected $primaryKey = 'id_pengajuan';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pengajuan',
        'id_jemaat',
        'jenis_pengajuan',
        'verifikasi_pengajuan',
        'catatan_pengajuan'
    ];
    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "PJ{$datePart}";

        $lastId = self::where('id_pengajuan', 'like', "{$prefix}%")
            ->orderByDesc('id_pengajuan')
            ->first();

        if ($lastId) {
            $lastId = $lastId->id_pengajuan;
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
    public function baptis(): HasMany
    {
        return $this->hasMany((Baptis::class), 'id_baptis', 'id_pengajuan');
    }
    public function pernikahan(): HasMany
    {
        return $this->hasMany((Pernikahan::class), 'id_pernikahan', 'id_pengajuan');
    }
}
