<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Documento' => 'App\Policies\DocumentoPolicy',
        'App\Models\Startup' => 'App\Policies\StartupPolicy',
        'App\Models\Proposta' => 'App\Policies\PropostaPolicy',
        'App\Models\Endereco' => 'App\Policies\EnderecoPolicy',
        'App\Models\Leilao'  => 'App\Policies\LeilaoPolicy',
        'App\Models\Telefone'  => 'App\Policies\TelefonePolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
