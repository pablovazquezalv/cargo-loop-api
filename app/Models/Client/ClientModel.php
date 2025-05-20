<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    //
     protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'rol_id',

        'postal_code',
        'profile_picture',
        'website',
        'description',
        
    ];
}
