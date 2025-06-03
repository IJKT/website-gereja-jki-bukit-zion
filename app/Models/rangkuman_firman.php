<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class rangkuman_firman extends Model
{
    protected $table = 'rangkuman_firman';
    protected $primaryKey = 'id_rangkuman_firman';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_rangkuman_firman',
        'id_pelayan_pnl',
        'nama_narasumber',
        'judul_rangkuman',
        'slug_rangkuman',
        'isi_rangkuman',
        'tgl_rangkuman',
        'gambar_rangkuman',
        'tipe_rangkuman',
        'kategori_sermons',
        'status_rangkuman',
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "RF{$datePart}";

        $lastId = self::where('id_rangkuman_firman', 'like', "{$prefix}%")
            ->orderByDesc('id_rangkuman_firman')
            ->first();

        if ($lastId) {
            $lastId = $lastId->id_rangkuman_firman;
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

    public function pelayan(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pelayan_pnl', 'id_pelayan');
    }
}
