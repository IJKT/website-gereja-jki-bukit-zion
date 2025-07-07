<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    protected $primaryKey = 'id_kontak';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_kontak',
        'nama',
        'email',
        'kategori',
        'pesan',
        'status',
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "KN{$datePart}";

        $lasKontak = self::where('id_kontak', 'like', "{$prefix}%")
            ->orderByDesc('id_kontak')
            ->first();

        if ($lasKontak) {
            $lastId = $lasKontak->id_kontak;
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
