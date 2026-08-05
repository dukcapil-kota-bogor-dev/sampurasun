<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'nik', 'nama', 'no_hp', 'jenis_kelamin', 'kecamatan', 'kelurahan', 'jenis_layanan_id', 'detail', 'jam_masuk', 'jam_di_balasan'
    ];

    public function jenisLayanan()
    {
        return $this->belongsTo(Category::class, 'jenis_layanan_id');
    }
}
