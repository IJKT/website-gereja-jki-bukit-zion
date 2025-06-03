<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detail_jadwal extends Model
{
    protected $table = 'detail_jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_jadwal',
        'id_pelayan',
        'nama_pendeta_undangan',
        'peran_pelayan',
    ];

    public function detail_jadwal(): BelongsTo
    {
        return $this->belongsTo(detail_jadwal::class, 'id_jadwal', 'id_jadwal');
    }
    public function pelayan(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pelayan', 'id_pelayan');
    }
}
