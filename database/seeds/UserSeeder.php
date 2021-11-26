<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
        $faker = Faker\Factory::create();
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                 'role'          => 'Admin',
                'password'       => bcrypt('12345678'),
                 'auth_token' => Str::random(60),
                'remember_token' => null,
            ],
        ];

        User::insert($users);

        foreach(range(1,10) as $id)
        {
            User::create([
                'name' => $faker->unique()->name,
                'email' => "user$id@user$id.com",
                'password' => bcrypt('password'),
                 'auth_token' => Str::random(60),
            ]);
        }
    }
}
