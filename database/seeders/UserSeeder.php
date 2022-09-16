<?php

namespace Database\Seeders;

use App\Models\Investidor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Empreendedor(a)',
            'email' => 'empreendedor@empreendedor.com',
            'tipo' => User::PROFILE_ENUM['entrepreneur'],
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'cpf' => '793.322.237-42',
            'sexo' => 2,
            'data_de_nascimento' => date("2001-01-30"),
        ]);

        User::create([
            'name' => 'Investidor',
            'email' => 'investidor@investidor.com',
            'tipo' => User::PROFILE_ENUM['investor'],
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'cpf' => '639.585.110-15',
            'sexo' => 2,
            'data_de_nascimento' => date("2001-01-30"),
        ]);

        User::create([
            'name' => 'Investidora',
            'email' => 'investidora@investidora.com',
            'tipo' => User::PROFILE_ENUM['investor'],
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'cpf' => '537.184.134-26',
            'sexo' => 1,
            'data_de_nascimento' => date('2001-01-30'),
        ]);

    }
}
