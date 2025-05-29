<?php

namespace App\Models\Trasportista;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dealer extends Authenticatable
{
    use HasApiTokens;
    

   
    protected $table = 'users';    
}
