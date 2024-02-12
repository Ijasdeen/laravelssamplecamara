<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
               'name'=>'Admin', 
               'email'=>'admin@yopmail.com',
               'phoneno'=>'9876542345',
               'password'=> bcrypt('Admin@123'),
               'occupation'=>'',
               'age'=>'',
               'user_image'=>'',
               'type'=>1,
               'status'=>'1'
            ] 
            
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
