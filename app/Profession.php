<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    //Si el nombre de la tabla es diferente al nombre del Modelo se debe especificar de la siguiente forma
    //protected $table = 'my_professions';
    //Usamos protected $fillable para evitar el error de ataques masivos MassAssignmentException
    protected $fillable=['title'];

    public function users(){
        return $this->hasMany(User::class);
    }
}
