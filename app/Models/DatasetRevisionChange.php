<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DatasetRevision;

class DatasetRevisionChange extends Model
{
    protected $table = 'dataset_revision_changes';

    protected $fillable = [
        'revision_id',
        'action',
        'target_type',
        'target_id',
        'before_json',
        'after_json'
    ];

    protected $casts = [
        'before_json' => 'array',
        'after_json' => 'array'
    ];

    public function revision()
    {
        return $this->belongsTo(DatasetRevision::class);
    }
}
