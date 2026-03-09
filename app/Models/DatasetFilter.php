<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dataset;

class DatasetFilter extends Model
{
    protected $table = 'dataset_filter';

    protected $fillable = [
        'dataset_id',
        'kolom'
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
