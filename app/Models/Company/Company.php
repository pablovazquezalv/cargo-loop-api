<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'description',
        'logo',
        'code',
        'postal_code',
    ];

  
}
