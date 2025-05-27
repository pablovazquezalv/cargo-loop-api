<?php

namespace App\Models\Invitation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Company\Company;
use App\Models\User\User;
use GuzzleHttp\Client;

class Invitation extends Model
{
    //
    protected $fillable = ['company_id', 'manager_id', 'email', 'code', 'accepted_at','user_id', 'status'];

    public static function generateCode()
    {
        do {
            $code = Str::random(4);
        } while (self::where('code', $code)->exists());

        return strtoupper($code);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function manager()
    {
        return $this->belongsTo(Client::class, 'user_id');
    }
}
