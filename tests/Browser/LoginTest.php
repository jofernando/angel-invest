<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_login_screen_can_be_rendered()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertInputPresent('email')
                ->assertInputPresent('password');
        });
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('button[type=submit]')
                ->assertAuthenticatedAs($user)
                ->assertPathIs('/startups');
        });
    }

    public function test_users_can_not_authenticate_without_registration()
    {
        $user = User::factory()->make();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('button[type=submit]')
                ->assertPathIs('/login')
                ->assertSee('Essas credenciais não foram encontradas em nossos registros')
                ->assertGuest();
        });
    }
}
