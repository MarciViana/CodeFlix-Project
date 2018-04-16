<?php

namespace CodeFlix\Models;

use Bootstrapper\Interfaces\TableInterface;
use CodeFlix\Notifications\DefaultResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements TableInterface,JWTSubject
{
    use Notifiable;
    use SoftDeletes; //trait que adiciona a exclusão lógica para videos
    const ROLE_ADMIN=1;
    const ROLE_CLIENT=2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function generatePassword($password = null){
        //se não tem senha, encripta uma string aleatoria de 8 caracteres
        //se tiver a senha, encripta a senha
        return !$password? bcrypt(str_random(8)):bcrypt($password);

    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new DefaultResetPasswordNotification($token));
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        // TODO: Implement getTableHeaders() method.
        return ['#','Nome','E-mail']; //mostra id, nome e e-mail do usuário
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        // TODO: Implement getValueForHeader() method.
        switch($header){
            case '#':
                return $this->id;
                break;
            case 'Nome':
                return $this->name;
                break;
            case 'E-mail':
                return $this->email;
                break;

        }
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
       return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
       return [
           'user' => [
               'id' => $this->id,
               'name' => $this->name,
               'email' => $this->email
           ]
       ];
    }
}
