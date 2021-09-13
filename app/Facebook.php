<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
     protected $fillable = [
        'id', 'usuario', 'email', 'password', 'avatar', 'condicion', 'id_user'
    ];

    public function usuarios(){
        
        return $this->hasMany('App\User');
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
}


