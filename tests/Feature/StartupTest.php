<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Documento;
use App\Models\Endereco;
use App\Models\Startup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class StartupTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Startup $startup;
    public Startup $unsavedStartup;
    public $file_1;
    public $file_2;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create();
        $this->file_1 = UploadedFile::fake()->image('logo_1.jpg');
        $file_path_1 = 'startups/logos/logo_1.jpg';
        $this->file_2 = UploadedFile::fake()->image('logo_2.jpg');
        $file_path_2 = 'startups/logos/logo_2.jpg';
        $this->startup = Startup::factory()->for($this->user)->forArea()->create(['logo' => $file_path_1]);
        Endereco::factory()->createEndereco($this->startup);
        Documento::create([
            'nome' => 'comprovante',
            'caminho' => 'startups/documentos/logo_1.jpg',
            'startup_id' => $this->startup->id
        ]);
        $this->unsavedStartup = Startup::factory()->for($this->user)->forArea()->make(['logo' => $file_path_2]);
    }

    public function test_screens_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get('startups/create');
        $response->assertStatus(200);
        $response = $this->actingAs($this->user)->get("startups/{$this->startup->id}/edit");
        $response->assertStatus(200);
        $response = $this->actingAs($this->user)->get("startups/{$this->startup->id}");
        $response->assertStatus(200);
    }

    public function test_user_who_does_not_own_the_startup_cannot_edit()
    {
        $another = User::factory()->create();
        $response = $this->actingAs($another)->put("startups/{$this->startup->id}", $this->startup->toArray());
        $response->assertForbidden();
    }

    public function test_startup_owner_user_can_edit()
    {
        $attributes = $this->startup->only([ 'nome', 'descricao', 'email', 'cnpj']);
        $attributes['area'] = $this->startup['area_id'];
        $new_nome = 'aaaaaaa';
        $attributes['nome'] = $new_nome;
        $response = $this->actingAs($this->user)->put("startups/{$this->startup->id}", $attributes);
        $edited = Startup::find($this->startup->id);
        $this->assertEquals($edited->nome, $new_nome);
        $response->assertRedirect("startups/{$this->startup->id}");
    }

    public function test_owner_user_can_not_edit_startup_removing_required_fields()
    {
        $attributes = $this->startup->only([ 'nome', 'descricao', 'email', 'cnpj']);
        $response = $this->actingAs($this->user)->put("startups/{$this->startup->id}", $attributes);
        $response->assertSessionHasErrors([
            'area' => 'O campo área é obrigatório.',
        ]);
    }

    public function test_owner_user_can_not_edit_non_existent_startup()
    {
        $attributes = $this->unsavedStartup->only([ 'nome', 'descricao', 'email', 'cnpj']);
        $response = $this->actingAs($this->user)->put("startups/0", $attributes);
        $response->assertStatus(404);
    }

    public function test_owner_user_can_not_update_cnpj_to_an_existent()
    {
        $this->unsavedStartup->save();
        $attributes = $this->startup->only([ 'nome', 'descricao', 'email']);
        $attributes['area'] = $this->startup['area_id'];
        $attributes['cnpj'] = $this->unsavedStartup->cnpj;
        $response = $this->actingAs($this->user)->put("startups/{$this->startup->id}", $attributes);
        $response->assertSessionHasErrors([
            'cnpj' => 'O campo CNPJ já está sendo utilizado.',
        ]);
    }

    public function test_logged_user_can_create_startup_with_all_required_fields()
    {
        $attributes = $this->unsavedStartup->toArray();
        $file = UploadedFile::fake()->image('avatar.jpg');
        $attributes['logo'] = $file;
        $attributes['area'] = $this->unsavedStartup->area->id;
        $response = $this->actingAs($this->user)->post('startups/', $attributes);
        $response->assertStatus(302);
        $created = Startup::all()->last();
        $response->assertSessionDoesntHaveErrors();
        Storage::disk('public')->assertExists($created->logo);
        $this->assertFileEquals($file, Storage::disk('public')->path($created->logo));
        $this->assertDatabaseHas('startups', [
            'nome' => $this->unsavedStartup->nome,
            'descricao' => $this->unsavedStartup->descricao,
            'email' => $this->unsavedStartup->email,
            'cnpj' => $this->unsavedStartup->cnpj,
        ]);
    }

    public function test_logged_user_can_not_create_startup_without_required_fields()
    {
        $attributes = $this->unsavedStartup->only([ 'nome', 'descricao', 'email', 'cnpj']);
        $response = $this->actingAs($this->user)->post("startups/", $attributes);
        $response->assertSessionHasErrors([
            'area' => 'O campo área é obrigatório.',
            'logo' => 'O campo logo é obrigatório.',
        ]);
        $this->assertDatabaseMissing('startups', [
            'nome' => $this->unsavedStartup->nome,
            'descricao' => $this->unsavedStartup->descricao,
            'email' => $this->unsavedStartup->email,
            'cnpj' => $this->unsavedStartup->cnpj,
        ]);
    }

    public function test_logged_user_can_not_create_startup_with_an_existent_cnpj()
    {
        $attributes = $this->unsavedStartup->only([ 'nome', 'descricao', 'email']);
        $attributes['area'] = $this->startup['area_id'];
        $attributes['cnpj'] = $this->startup->cnpj;
        $response = $this->actingAs($this->user)->post("startups", $attributes);
        $response->assertSessionHasErrors([
            'cnpj' => 'O campo CNPJ já está sendo utilizado.',
        ]);
    }

    public function test_logged_user_can_not_create_startup_without_fields()
    {
        $response = $this->actingAs($this->user)->post("startups", []);
        $response->assertSessionHasErrors([
            'nome' => 'O campo nome é obrigatório.',
            'descricao' => 'O campo descrição é obrigatório.',
            'logo' => 'O campo logo é obrigatório.',
            'email' => 'O campo e-mail é obrigatório.',
            'area' => 'O campo área é obrigatório.'
        ]);
    }



    public function test_owner_can_delete_startup()
    {
        $response = $this->actingAs($this->user)->delete("startups/".$this->startup->id);
        $this->assertTrue($this->startup->refresh()->trashed());
    }
}
