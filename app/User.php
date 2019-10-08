<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profession_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public static function findByEmail($email){
        //Puedo utilizar static si utilizo la clase del metodo. En este caso User
        return static::where(compact('email'))->first();
    }
    public function isAdmin()
    {
       return $this->is_admin;
    }

    //Este metodo pasa el id como profession_id. Si definimos la clave foranea con otra convención debemos
    // pasar el id como segundo argumento en belongsTo: return $this->belongsTo(Profession::class,'id_profession');
    // O si se desea utilizar otra columna return $this->belongsTo(Profession::class, 'profession_name', 'name');
    //En este caso Eloquent buscará la relación entre la columna profession_name del modelo Users
    // y la columna name del modelo Profession.

    public function profession(){
       return $this->belongsTo(Profession::class);
    }
}
