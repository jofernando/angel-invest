<?php

namespace Database\Seeders;

use App\Models\Investidor;
use App\Models\Pagamento;
use Illuminate\Database\Seeder;

class PagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $investidores = Investidor::all();
        foreach ($investidores as $investidor) {
            Pagamento::factory()->for($investidor)->count(160)->create();
        }
    }
}
