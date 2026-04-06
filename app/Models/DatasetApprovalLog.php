<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DatasetApprovalLog extends Model
{
    protected $table = 'dataset_approval_logs';

    protected $fillable = [
        'dataset_id',
        'action',
        'catatan',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
