<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembukuan extends Model
{
    /** @use HasFactory<\Database\Factories\PembukuanFactory> */
    use HasFactory;
    protected $table = 'pembukuan';
    protected $primaryKey = 'id_pembukuan';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_pembukuan', 'jenis_pembukuan', 'nominal_pembukuan', 'tgl_pembukuan', 'deskripsi_pembukuan', 'catatan_pembukuan'];
}
