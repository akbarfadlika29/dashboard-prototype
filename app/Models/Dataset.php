<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DatasetRevision;

class Dataset extends Model
{
    protected $table = 'dataset';

    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const REVISION_DRAFT = 'draft';
    const REVISION_PENDING = 'pending';
    const REVISION_APPROVED = 'approved';
    const REVISION_REJECTED = 'rejected';

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
        'approved_at',
        'count_approved',
        'first_created',
        'file_storage',
        'file_original_name',
        'file_mime',
        'file_size',
    ];

    protected $casts = [
        'schema_json' => 'array',
        'kolom' => 'array',
        'approved_at' => 'datetime'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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

    public function approvalLogs()
    {
        return $this->hasMany(DatasetApprovalLog::class);
    }

    public function revisions()
    {
        return $this->hasMany(DatasetRevision::class);
    }

    public function activeRevision()
    {
        return $this->hasOne(DatasetRevision::class)
            ->whereIn('status', ['draft', 'pending'])
            ->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT LOGIC
    |--------------------------------------------------------------------------
    */

    public function isEditable()
    {
        return in_array($this->status, [
            self::STATUS_DRAFT,
            self::STATUS_REJECTED,
            self::STATUS_APPROVED
        ]);
    }

    public function isRevisionMode()
    {
        return $this->isApproved();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    public function getOrCreateDraftRevision()
    {
        $revision = $this->activeRevision;

        if ($revision) {
            return $revision;
        }

        return DatasetRevision::create([
            'dataset_id' => $this->id,
            'status' => 'draft',
            'created_by' => auth()->id()
        ]);
    }

    public function canEdit()
    {
        return in_array($this->status, [
            self::STATUS_DRAFT,
            self::STATUS_REJECTED,
            self::STATUS_APPROVED,
        ]);
    }

    public function displayData()
    {
        /*
        |--------------------------------------------------------------------------
        | BASE DATA
        |--------------------------------------------------------------------------
        */

        $baseData = $this->data()->get();

        /*
        |--------------------------------------------------------------------------
        | NO ACTIVE REVISION
        |--------------------------------------------------------------------------
        */

        if (!$this->activeRevision) {
            return $baseData;
        }

        $revision = $this->activeRevision;

        /*
        |--------------------------------------------------------------------------
        | LOAD CHANGES
        |--------------------------------------------------------------------------
        */

        $changes = $revision->changes;

        /*
        |--------------------------------------------------------------------------
        | APPLY REVISION CHANGES VIRTUALLY
        |--------------------------------------------------------------------------
        */

        $collection = collect($baseData->map(function ($item) {
            return clone $item;
        }));

        foreach ($changes as $change) {

            switch ($change->action) {

                /*
                |--------------------------------------------------------------------------
                | CREATE ROW
                |--------------------------------------------------------------------------
                */

                case 'create_row':

                    $fake = new DatasetData();

                    $fake->id = 'draft_' . uniqid();

                    $fake->data_json =
                        $change->after_json['data_json'] ?? [];

                    $collection->push($fake);

                    break;

                /*
                |--------------------------------------------------------------------------
                | UPDATE ROW
                |--------------------------------------------------------------------------
                */

                case 'update_row':

                    $row = $collection->firstWhere(
                        'id',
                        $change->target_id
                    );

                    if ($row) {

                        $row->data_json =
                            $change->after_json['data_json'] ?? [];
                    }

                    break;

                /*
                |--------------------------------------------------------------------------
                | DELETE ROW
                |--------------------------------------------------------------------------
                */

                case 'delete_row':

                    $collection = $collection->reject(function ($item) use ($change) {
                        return $item->id == $change->target_id;
                    });

                    break;
            }
        }

        return $collection->values();
    }

    public function hasDraftRevision(): bool
    {
        return $this->revisions()
            ->whereIn('status', [
                self::REVISION_DRAFT,
                self::REVISION_PENDING
            ])
            ->exists();
    }

    public function isDirectEdit(): bool
    {
        return in_array($this->status, [
            self::STATUS_DRAFT,
            self::STATUS_REJECTED,
        ]);
    }
    
}