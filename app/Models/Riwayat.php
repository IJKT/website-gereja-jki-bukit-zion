<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $primaryKey = 'id_log';
    protected $keyType = 'string';
    public $timestamps = false;

    public function pelayan(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pelayan_creator', 'id_pelayan');
    }
}
