<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pernikahan extends Model
{
    protected $table = 'pernikahan';
    protected $primaryKey = 'id_pernikahan';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pernikahan',
        'id_jemaat_p',
        'id_jemaat_w',
        'id_pendeta',
        'tgl_pernikahan'
    ];

    public function pengajuan_jemaat(): BelongsTo
    {
        return $this->belongsTo(PengajuanJemaat::class, 'id_pernikahan', 'id_pengajuan');
    }
    public function jemaat_pria(): BelongsTo
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat_p', 'id_jemaat');
    }
    public function jemaat_wanita(): BelongsTo
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat_w', 'id_jemaat');
    }
    public function pendeta(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pendeta', 'id_pelayan');
    }
}
