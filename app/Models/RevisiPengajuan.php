<?php

namespace App\Models;

use App\Models\PengajuanJemaat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevisiPengajuan extends Model
{
    protected $table = 'revisi_pengajuan';
    protected $primaryKey = 'id_revisi';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_revisi',
        'id_pengomentar',
        'komentar',
        'tgl_revisi',
    ];

    public static function addRevision($id_revisi, $id_pengomentar, $komentar)
    {
        self::create([
            'id_revisi' => $id_revisi,
            'id_pengomentar' => $id_pengomentar,
            'komentar' =>  $komentar,
            'tgl_revisi' => now(),
        ]);
    }

    public function PengajuanJemaat(): BelongsTo
    {
        return $this->belongsTo(PengajuanJemaat::class, 'id_revisi', 'id_pengajuan');
    }

    public function Pengomentar(): BelongsTo
    {
        return $this->belongsTo(Pelayan::class, 'id_pengomentar', 'id_pelayan');
    }
}
