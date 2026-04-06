<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\DatasetData;
use App\Models\DatasetFilter;
use App\Models\Seksi;
use App\Models\User;
use App\Models\DatasetApprovalLog;

class Dataset extends Model
{
    protected $table = 'dataset';

    protected $fillable = [
        'kategori_id',
        'seksi_id',
        'nama',
        'slug',
        'deskripsi',
        'schema_json',
        'kolom',
        'tipe_grafik_default',
        'status',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'schema_json' => 'array',
        'kolom' => 'array',
        'approved_at' => 'datetime'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }

    public function data()
    {
        return $this->hasMany(DatasetData::class);
    }

    public function filters()
    {
        return $this->hasMany(DatasetFilter::class);
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

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function approvalLogs()
    {
        return $this->hasMany(DatasetApprovalLog::class);
    }

    public function canEdit()
    {
        return in_array($this->status, ['draft', 'rejected']);
    }
}
