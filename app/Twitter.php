<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twitter extends Model
{
    protected $fillable = [
        'id', 'usuario', 'correo', 'provider', 'provider_id', 'password', 'condicion', 'id_user'
    ];

}
