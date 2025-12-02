<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'nama',
        'jabatan'
    ];

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
