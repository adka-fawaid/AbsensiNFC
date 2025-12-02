<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Peserta untuk sistem absensi NFC.
 * 
 * Merepresentasikan data peserta yang dapat melakukan absensi
 * menggunakan kartu NFC dengan UID unik.
 * 
 * @package App\Models
 * @author Sistem Absensi NFC
 * @version 1.0.0
 * 
 * @property int $id
 * @property string|null $uid UID kartu NFC (unik, nullable)
 * @property string $nama Nama lengkap peserta
 * @property string $nim Nomor Induk Mahasiswa (unik)
 * @property string $fakultas Nama fakultas/jurusan
 * @property string|null $jabatan Jabatan peserta (nullable)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Peserta extends Model
{
    use HasFactory;

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
