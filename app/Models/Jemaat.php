<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jemaat extends Model
{

    use HasFactory;
    protected $table = 'jemaat';
    protected $primaryKey = 'id_jemaat';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_jemaat',
        'username',
        'nama_jemaat',
        'jk_jemaat',
        'nik_jemaat',
        'tmpt_lahir_jemaat',
        'tgl_lahir_jemaat',
        'telp_jemaat',
        'email_jemaat',
        'alamat_jemaat',
        'hak_akses_jemaat',
        'status_jemaat',
        'wilayah_komsel_jemaat'
    ];

    public static function generateNextId()
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');
        $prefix = "JM{$datePart}";

        $lastId = self::where('id_jemaat', 'like', "{$prefix}%")
            ->orderByDesc('id_jemaat')
            ->first();

        if ($lastId) {
            $lastId = $lastId->id_jemaat;
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
    //RELATIONSHIPS
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'username', 'username');
    }
    public function pelayan(): hasOne
    {
        return $this->hasOne(Pelayan::class, 'id_jemaat', 'id_jemaat');
    }
    public function pengajuan_jemaat(): HasMany
    {
        return $this->hasMany(PengajuanJemaat::class, 'id_jemaat', 'id_jemaat');
    }
    public function pernikahan_pria(): hasOne
    {
        return $this->hasOne(Pernikahan::class, 'id_jemaat_p', 'id_jemaat');
    }
    public function pernikahan_wanita(): hasOne
    {
        return $this->hasOne(Pernikahan::class, 'id_jemaat_w', 'id_jemaat');
    }

    public function pasangan()
    {
        $pernikahan = $this->pernikahan_pria()->first()
            ?? $this->pernikahan_wanita()->first();

        if (!$pernikahan) return null;

        return $pernikahan->id_jemaat_p === $this->id_jemaat
            ? $pernikahan->jemaat_wanita
            : $pernikahan->jemaat_pria;
    }
}
