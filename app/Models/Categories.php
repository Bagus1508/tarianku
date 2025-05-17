<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    // Gunakan SoftDeletes jika ingin mengaktifkan fitur soft delete
    use SoftDeletes;

    // Nama tabel jika berbeda dengan konvensi plural
    protected $table = 'categories';

    // Tentukan atribut yang bisa diisi (Mass Assignment)
    protected $fillable = ['name', 'attachment'];

    // Tentukan apakah model menggunakan timestamps (created_at, updated_at)
    public $timestamps = true;

    // Tentukan format tanggal untuk SoftDeletes (jika menggunakan)
    protected $dates = ['deleted_at'];

    // Jika perlu, tambahkan relasi jika model memiliki relasi dengan model lain
    // Contoh: Jika Category memiliki banyak produk
    public function dances()
    {
        return $this->hasMany(Dance::class);
    }
}
