<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dataset;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi'
    ];

    public function dataset()
    {
        return $this->hasMany(Dataset::class);
    }
}
