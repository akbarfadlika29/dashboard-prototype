<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\DatasetData;
use App\Models\DatasetFilter;

class Dataset extends Model
{
    protected $table = 'dataset';

    protected $fillable = [
        'kategori_id',
        'nama',
        'slug',
        'deskripsi',
        'schema_json',
        'kolom',
        'tipe_grafik_default',
        'aktif'
    ];

    protected $casts = [
        'schema_json' => 'array',
        'kolom' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function data()
    {
        return $this->hasMany(DatasetData::class);
    }

    public function filters()
    {
        return $this->hasMany(DatasetFilter::class);
    }
}
