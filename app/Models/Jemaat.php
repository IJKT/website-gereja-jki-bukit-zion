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
        'status_jemaat'
    ];

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
    public function baptis(): HasMany
    {
        return $this->hasMany(Baptis::class, 'id_jemaat', 'id_jemaat');
    }
    public function pernikahan_pria(): HasMany
    {
        return $this->hasMany(Pernikahan::class, 'id_jemaat_p', 'id_jemaat');
    }
    public function pernikahan_wanita(): HasMany
    {
        return $this->hasMany(Pernikahan::class, 'id_jemaat_w', 'id_jemaat');
    }
}
