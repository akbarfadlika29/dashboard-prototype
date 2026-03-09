<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dataset;

class DatasetData extends Model
{
    protected $table = 'dataset_data';

    protected $fillable = [
        'dataset_id',
        'tahun',
        'data_json'
    ];

    protected $casts = [
        'data_json' => 'array'
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
