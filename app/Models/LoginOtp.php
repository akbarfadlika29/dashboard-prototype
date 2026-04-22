<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LoginOtp extends Model
{
    protected $fillable = ['user_id', 'otp', 'expired_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
