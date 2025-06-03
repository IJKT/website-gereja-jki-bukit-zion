<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detail_lagu_pujian extends Model
{
    protected $table = 'detail_lagu_pujian';
    protected $primaryKey = 'id_lagu';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_lagu',
        'id_jadwal',
        'urutan_lagu',
    ];

    public function lagu_pujian(): BelongsTo
    {
        return $this->belongsTo(lagu_pujian::class, 'id_lagu', 'id_lagu');
    }
    public function jadwal_ibadah(): BelongsTo
    {
        return $this->belongsTo(jadwal_ibadah::class, 'id_jadwal', 'id_jadwal');
    }
}
