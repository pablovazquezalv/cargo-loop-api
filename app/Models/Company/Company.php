<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\pedido\pedidos;

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

    public function company()
{
    return $this->belongsTo(Company::class);
}

    public function users()
    {
        return $this->hasMany(User::class);


    
    }

   

    public function dealers()
    {
        return $this->hasMany(User::class)->where('rol_id', 3);
    }

    public function deliveries()
    {
        return $this->hasMany(pedidos::class);
    }   

}
