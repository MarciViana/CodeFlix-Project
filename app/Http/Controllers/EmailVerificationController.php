<?php

namespace CodeFlix\Http\Controllers;

use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use Jrean\UserVerification\Traits\VerifiesUsers;

class EmailVerificationController extends Controller
{
    use VerifiesUsers; //trait que verifica os usuários

    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function redirectAfterVerification() //para onde vamos redirecionar após a verificação
    {
        $this->loginUser(); //antes de acessar a área administrativa vai fazer o login
        return url('admin/user/settings');

    }
    protected function loginUser(){
        $email = \Request::get('email');
        $user = $this->repository->findByField('email',$email)->first();
        \Auth::login($user);
    }

}
