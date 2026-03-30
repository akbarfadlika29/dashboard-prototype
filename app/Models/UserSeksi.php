<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSeksi extends Model
{
    protected $table = 'user_seksi';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'seksi_id',
    ];
}
