<?php

namespace CodeFlix\Repositories;

use Jrean\UserVerification\Facades\UserVerification;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use CodeFlix\Models\User;


/**
 * Class UserRepositoryEloquent
 * @package namespace CodeFlix\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function create(array $attributes)
    {
        //funções do store
        $attributes['role'] = User::ROLE_ADMIN; //todo usuário cadastrado será administrativo
        $attributes['password'] = User::generatePassword();
        //cria usuário com esses dados
        $model = parent::create($attributes);
       // $aux = new UserVerification($model);
       // $aux->generate($model);
       // $aux->send($model); //envia o email
        UserVerification::generate($model);
        UserVerification::send($model, 'Sua conta foi criada!'); //envia o email
        return $model;
    }
    public function update(array $attributes, $id)
    {
        if(isset($attributes['password'])){
            $attributes['password'] = User::generatePassword($attributes['password']);
        }
        $model = parent::update($attributes,$id);
        return $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
