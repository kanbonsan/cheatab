<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ["Hanako", "hanako@example1.com", "hanako11"],
            ["Taro", "taro@example2.com", "taro11"],
            ["Ichiro","ichiro@example3.com","ichiro11"]
        ];

        foreach( $users as $user){
            $row = new User;
            $row->name =$user[0];
            $row->email=$user[1];
            $row->password=$user[2];
            $row->save();
        }
        //
    }
}
