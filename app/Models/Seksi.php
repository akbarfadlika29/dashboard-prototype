<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Dataset;

class Seksi extends Model
{
    protected $table = 'seksi';

    protected $fillable = [
        'nama'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_seksi');
    }

    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }
}
