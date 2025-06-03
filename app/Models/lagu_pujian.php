<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class lagu_pujian extends Model
{
    protected $table = 'lagu_pujian';
    protected $primaryKey = 'id_lagu';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_lagu',
        'nama_lagu',
        'link_lagu',
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "LI{$datePart}";

        $lastLagu = self::where('id_lagu', 'like', "{$prefix}%")
            ->orderByDesc('id_lagu')
            ->first();

        if ($lastLagu) {
            $lastId = $lastLagu->id_lagu;
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

    public function detail_lagu_pujian(): HasMany
    {
        return $this->hasMany(detail_lagu_pujian::class, 'id_lagu', 'id_lagu');
    }
}
