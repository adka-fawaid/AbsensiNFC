<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal',
        'jam_mulai',
        'jam_batas_tepat',
        'lokasi',
        'keterangan'
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
