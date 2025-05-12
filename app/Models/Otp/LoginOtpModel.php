<?php

namespace App\Models\Otp;

use App\Models\Trasportista\UserTransportista;
use App\Models\Trasportista\UserTrasportista;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginOtpModel extends Model
{
    use HasFactory;

    protected $table = 'login_otps';

    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];

    public function userTransportista()
    {
        return $this->belongsTo(UserTrasportista::class, 'user_id');
    }
}
