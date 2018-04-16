<?php

use CodeFlix\Models\User;
use Illuminate\Database\Migrations\Migration;

class CreateUserAdminData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() //cria o usuário
    {
        $model = User::create([
            //env(): variaveis de ambiente
            'name' => env('ADMIN_DEFAULT_NAME', 'Administrator'), //Administrator no .env
            'email' => env('ADMIN_DEFAULT_EMAIL', 'admin@user.com'), //admin@user.com
            //bcrypt criptografa a senha
            'password' => bcrypt(env('ADMIN_DEFAULT_PASSWORD', 'secret')),
            'role' =>  \CodeFLix\Models\User::ROLE_ADMIN
        ]);
        $model->verified = true;
        $model->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() //remove o usuário
    {
        //armazena na variavel o primeiro resultado do where (email)
        $table = (new User())->getTable();
        \DB::table($table)
            ->where('email', '=', env('ADMIN_DEFAULT_EMAIL', 'admin@user.com'))
            ->delete();

    }
}
