<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rootPath = config('filesystems.disks.videos_local.root');
        \File::deleteDirectory($rootPath,true); //exclui as pastas de videos_test
         $this->call(UsersTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);

    }
}
