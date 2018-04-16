<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //criou 20 usuários
        factory(\CodeFlix\Models\User::class,20)
            ->states('admin')
            ->create()->each(function ($user){ //cada usuário da coleção passará pela função
                $user->verified = true;
                $user->save();
            });
    }
}
