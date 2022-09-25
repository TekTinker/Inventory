<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Aniket";
        $user->email = "admin@gmail.com";
        $user->password = bcrypt('admin');
        $user->save();
    }
}
