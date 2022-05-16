<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Laravel\Fortify\Features;
use App\Models\User;

class RegistrationTest extends DuskTestCase
{
    public function test_registration_screen_can_be_rendered()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('Cadastro');
        });
    }

    public function test_new_users_can_register() {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register')
                    ->attach('foto_do_perfil', __DIR__ . '/img/01.png')
                    ->type('nome', "Daniela Bárbara Agatha Mendes")
                    ->type('email', "teste_view@teste.com")
                    ->type('cpf', '394.263.921-14')
                    ->script("document.querySelector('input[name=data_de_nascimento]').value = '1986-01-25'");
            $browser->select('sexo', User::SEXO_ENUM['feminine'])
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->waitForText('Tudo ok!')
                    ->check('termos')
                    ->press('Cadastrar')
                    ->assertSee('Minhas startups');
            $this->resetar_session();
        });
    }

    public function test_new_users_showing_errors() {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register')
                    ->waitForText('Cadastro')
                    ->attach('foto_do_perfil', __DIR__ . '/img/01.png')
                    ->type('nome', "Daniela Bárbara Agatha Mendes")
                    ->type('email', "teste_view@teste.com")
                    ->type('cpf', '394.263.921-12')
                    ->script("document.querySelector('input[name=data_de_nascimento]').value = '" . now()->addDays(5)->format('Y-m-d') . "'");
            $browser->select('sexo', User::SEXO_ENUM['feminine'])
                    ->type('password', 'password')
                    ->type('password_confirmation', 'passwords')
                    ->waitForText('As senhas não são iguais!')
                    ->check('termos')
                    ->press('Cadastrar')
                    ->waitForText('Cadastro')
                    ->assertSee('O campo email já está sendo utilizado.')
                    ->assertSee('O campo data de nascimento deve ser uma data anterior a hoje.')
                    ->assertSee('O campo cpf não é um CPF válido.')
                    ->assertSee('O campo senha de confirmação não confere.');
        });
    }
}
