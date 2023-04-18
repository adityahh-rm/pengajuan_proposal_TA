<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => "Siti Rukmini",
                'email' => 'sitirukmini@ftunsur.ac.id',
                'password' => bcrypt('sitirukmini'),
                'roles_id' => 1
            ],
            [
                'name' => "Finsa Nurpandi",
                'email' => 'finsa@ftunsur.ac.id',
                'password' => bcrypt('finsanurpandi'),
                'roles_id' => 2
            ],
        ];

        foreach($user as $key => $value) {
            User::create($value);
        }
    }
}
