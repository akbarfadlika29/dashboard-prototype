<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dataset;
use App\Models\DatasetRevisionChange;
use App\Models\DatasetFileRevisionChange;
use App\Models\User;

class DatasetRevision extends Model
{
    protected $table = 'dataset_revisions';

    protected $fillable = [
        'dataset_id',
        'status',
        'catatan',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime'
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

    public function changes()
    {
        return $this->hasMany(DatasetRevisionChange::class, 'revision_id');
    }

    public function latestFileChange()
    {
        return $this->hasOne(DatasetFileRevisionChange::class, 'revision_id')
            ->latestOfMany();
    }

    public function changeFiles()
    {
        return $this->hasMany(DatasetFileRevisionChange::class, 'revision_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
