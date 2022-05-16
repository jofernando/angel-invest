<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $this->check_registration();

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled()
    {
        if (Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    public function test_new_users_can_register()
    {
        $this->check_registration();

        $response = $this->post('/register', [
            'profile' => User::PROFILE_ENUM['entrepreneur'],
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '512.716.580-54',
            'password' => 'password',
            'password_confirmation' => 'password',
            'data_de_nascimento' => date('1999-02-13'),
            'sexo' => User::SEXO_ENUM['masculine'],
            'termos' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/startups');
    }

    public function test_new_user_filling_in_wrong_cpf() {
        $this->check_registration();

        $response = $this->get('/register');

        $response = $this->post('/register', [
            'profile' => User::PROFILE_ENUM['entrepreneur'],
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '512.716.580-00', // Invalid CPF
            'password' => 'password',
            'password_confirmation' => 'password',
            'data_de_nascimento' => date('1999-02-13'),
            'sexo' => User::SEXO_ENUM['masculine'],
            'termos' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertGuest();
        $response->assertRedirect(env('APP_URL') . '/register');
    }

    public function test_new_user_with_different_passwords() {
        $this->check_registration();

        $response = $this->get('/register');

        $response = $this->post('/register', [
            'profile' => User::PROFILE_ENUM['entrepreneur'],
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '512.716.580-00', // Invalid CPF
            'password' => 'passwords',
            'password_confirmation' => 'password',
            'data_de_nascimento' => date('1999-02-13'),
            'sexo' => User::SEXO_ENUM['masculine'],
            'termos' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertGuest();
        $response->assertRedirect(env('APP_URL') . '/register');
    }

    public function test_new_user_not_filling_all_fields() {
        $this->check_registration();

        $response = $this->get('/register');

        $response = $this->post('/register', [
            'profile' => User::PROFILE_ENUM['entrepreneur'],
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '512.716.580-00', // Invalid CPF
            'password' => 'password',
            'password_confirmation' => 'password',
            'data_de_nascimento' => null,
            'sexo' => null,
            'termos' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertGuest();
        $response->assertRedirect(env('APP_URL') . '/register');
    }

    public function new_user_without_choosing_your_profile() {
        $this->check_registration();

        $response = $this->get('/register');

        $response = $this->post('/register', [
            'profile' => null,
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '512.716.580-00', // Invalid CPF
            'password' => 'password',
            'password_confirmation' => 'password',
            'data_de_nascimento' => date('1999-02-13'),
            'sexo' => User::SEXO_ENUM['masculine'],
            'termos' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertGuest();
        $response->assertRedirect(env('APP_URL') . '/register');
    }

    private function check_registration() {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }
    }
}
