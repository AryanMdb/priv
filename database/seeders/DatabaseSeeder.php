<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DeliveryCharge;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
     
         User::create($user);

         $delivery_charges = [
            [
                'from_price' => 1,
                'to_price' => 400,
                'delivery_charges' => 39
            ],
            [
                'from_price' => 401,
                'to_price' => 800,
                'delivery_charges' => 29
            ],
            [
                'from_price' => 801,
                'to_price' => 1200,
                'delivery_charges' => 19
            ],
            [
                'from_price' => 1201,
                'to_price' => 1600,
                'delivery_charges' => 9
            ],
        ];
        
        foreach ($delivery_charges as $charge) {
            DeliveryCharge::create([
                'from_price' => $charge['from_price'],
                'to_price' => $charge['to_price'],
                'delivery_charges' => $charge['delivery_charges']
            ]);
        }
        $this->call(PermissionSeeder::class);
    }
}
