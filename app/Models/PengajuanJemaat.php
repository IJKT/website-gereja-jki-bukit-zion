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
