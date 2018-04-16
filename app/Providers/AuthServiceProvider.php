<?php

namespace CodeFlix\Providers;

use CodeFlix\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'CodeFlix\Model' => 'CodeFlix\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /*Facade Gate determina quem passa ou não, recebe o usuário que estamos querendo
        autorizar*/
        \Gate::define('admin', function($user){

            /*Se for admin, retorna true, se não, retorna falso*/
            return $user->role == User::ROLE_ADMIN;
        });
        //
    }
}
