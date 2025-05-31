<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'username', 'username');
    }

    public function pelayan(): hasOne
    {
        return $this->hasOne(Pelayan::class, 'id_jemaat', 'id_jemaat');
    }
}
