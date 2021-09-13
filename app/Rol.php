<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['rol', 'descripcion', 'condicion'];
    public $timestamp = false;

    public function usuarios()
    {
        return $this->hasMany('App\User');
    }
}
