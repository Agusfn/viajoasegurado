<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'name', 'email', 'password',
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
     * Verificar si el usuario es super admin
     * @return boolean       
     */
    public function isSuperAdmin()
    {
        if($this->role == "superadmin")
            return true;
        else
            return false;
    }



    /**
     * Verificar si el usuario es admin
     * @param  boolean $atLeast si es admin o superior
     * @return boolean       
     */
    public function isAdmin($atLeast = false)
    {
        if($this->role == "admin" || ($atLeast && $this->role == "superadmin"))
            return true;
        else
            return false;
    }


    /**
     * Verificar si el usuario es operativo
     * @param  boolean $atLeast si es operativo o superior
     * @return boolean       
     */
    public function isOperative($atLeast = false)
    {
        if($this->role == "operative" || ($atLeast && ($this->role == "admin" || $this->role == "superadmin")))
            return true;
        else
            return false;
    }


    /**
     * Si la cuenta está inhabilitada.
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }


    /**
     * Actualiza fecha y hora de última actividad
     * @return null
     */
    public function updateActivity()
    {
        $this->last_activity = date("Y-m-d H:i:s");
        $this->save();
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


}
