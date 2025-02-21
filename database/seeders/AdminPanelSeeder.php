<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = array(
               'name' => 'Admin',
               'email' => 'privykart12@gmail.com',
               'phone' => '0123456789',
                'role' => 'admin',
               'password' => 'test@123',
            );
            /*,
            [
               'name'=>'User',
               'email'=>'user@gmail.com',
                'is_admin'=>'0',
               'password'=> Hash::make('12345678'),
            ],*/
        
            User::create($user);
       
    }
}
