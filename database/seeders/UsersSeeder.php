<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $faker = \Faker\Factory::create();

            DB::table("users")->insert([
                "name" => $faker->name(),
                "email" => $faker->safeEmail,
                "phone" => $faker->numerify('##########'),
                "password" => Hash::make('pass2020'),
                "qualification" => $faker->text(20),
                "college" => $faker->text(15),
                "dob" => $faker->date,
                "created_at" => now(),
                "updated_at" => now(),
                "profile_image" => 'http://127.0.0.1:8000/storage/images/user_3.jpg',
                "cgpa" => $faker->numberBetween(0, 10),
                "hobby" => $faker->randomElement(["Reading", "Singing", "Dancing", "Swimming"]),
                "work_experience" => $faker->text(50),
            ]);
        }
    }
}
