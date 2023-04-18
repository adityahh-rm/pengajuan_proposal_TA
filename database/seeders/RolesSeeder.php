<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role =[
            ['name' => 'prodi'],
            ['name' => 'koordinator'],
            ['name' => 'dosen'],
            ['name' => 'mahasiswa'],
        ];

        foreach($role as $key => $value) {
            Roles::create($value);
        }
    }
}
