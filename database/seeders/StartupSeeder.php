<?php

namespace Database\Seeders;

use App\Models\Startup;
use App\Models\User;
use Illuminate\Database\Seeder;

class StartupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Startup::factory()->withLogo()->hasEndereco()->hasTelefones(1)->hasDocumentos(3)->for(User::where('tipo', 1)->first())->forArea()->count(50)->create();
    }
}
