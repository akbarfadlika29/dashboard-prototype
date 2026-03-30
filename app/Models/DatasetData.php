<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dataset;
use App\Models\User;

class DatasetData extends Model
{
    protected $table = 'dataset_data';

    protected $fillable = [
        'dataset_id',
        'data_json',
        'created_by'
    ];

    protected $casts = [
        'data_json' => 'array'
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
