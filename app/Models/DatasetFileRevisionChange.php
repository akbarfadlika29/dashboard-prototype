<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatasetFileRevisionChange extends Model
{
    protected $table = 'dataset_file_revision_changes';

    protected $fillable = [
        'revision_id',
        'action',
        'before_file_storage',
        'after_file_storage',
        'before_file_original_name',
        'after_file_original_name',
        'before_file_mime',
        'after_file_mime',
        'before_file_size',
        'after_file_size',
    ];


    public function revision()
    {
        return $this->belongsTo(DatasetRevision::class);
    }
}
