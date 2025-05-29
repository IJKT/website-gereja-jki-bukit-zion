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

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'username', 'username');
    }

    public function pelayan(): hasOne
    {
        return $this->hasOne(Pelayan::class, 'id_jemaat', 'id_jemaat');
    }
}
