<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Baptis extends Model
{
    protected $table = 'baptis';
    protected $primaryKey = 'id_baptis';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_baptis',
        'id_jemaat',
        'id_pembaptis',
        'tgl_baptis',
        'bukti_baptis'
    ];
    public function pengajuan_jemaat(): BelongsTo
    {
        return $this->belongsTo(PengajuanJemaat::class, 'id_baptis', 'id_pengajuan');
    }
    public function jemaat(): BelongsTo
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }
    public function pembaptis(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pembaptis', 'id_pelayan');
    }
    public function pengajar(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pengajar', 'id_pelayan');
    }
}
