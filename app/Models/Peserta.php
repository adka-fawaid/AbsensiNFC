<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Peserta - Data anggota BEM UDINUS
 */
class Peserta extends Model
{

    /**
     * Atribut yang dapat diisi secara mass assignment.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'uid',
        'nama', 
        'nim',
        'fakultas',
        'jabatan'
    ];

    /**
     * Relasi ke model Absensi.
     * 
     * Satu peserta dapat memiliki banyak record absensi.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
