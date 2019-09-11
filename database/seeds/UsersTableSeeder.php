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
        DB::table('users')->insert([
            'name' => 'Super Usuário',
            'email' => 'superUsuario@abv.com',
            'password' => bcrypt('senha#2019!'),
            'perfil' => 'super user',
            'reset' => 'não',
        ]);
    }
}
