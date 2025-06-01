<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class jadwal_ibadah extends Model
{
    protected $table = 'jadwal_ibadah';
    protected $primaryKey = 'id_jadwal';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_jadwal',
        'jenis_ibadah',
        'tgl_ibadah',
        'backtrack',
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "JI{$datePart}";

        $lastJadwal = self::where('id_jadwal', 'like', "{$prefix}%")
            ->orderByDesc('id_jadwal')
            ->first();

        if ($lastJadwal) {
            $lastId = $lastJadwal->id_jadwal;
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

    public function detail_jadwal(): HasMany
    {
        return $this->hasMany(detail_jadwal::class, 'id_jadwal', 'id_jadwal');
    }
}
