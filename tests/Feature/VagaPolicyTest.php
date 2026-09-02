<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vaga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


class VagaPolicyTest extends TestCase
{
    use RefreshDatabase;


    protected function criarVaga(User $dono, array $atributos = []): Vaga
    {
        return Vaga::create(array_merge([
            'empresa'   => 'Empresa Teste',
            'cargo'     => 'Dev PHP Júnior',
            'link_vaga' => 'https://exemplo.com/vaga',
            'anotacoes' => 'Anotação de teste',
            'status'    => 'aplicado',
            'user_id'   => $dono->id,
        ], $atributos));
    }

    #[Test]
    public function usuario_consegue_ver_apenas_suas_proprias_vagas_na_home()
    {
        $usuario = User::factory()->create();
        $outroUsuario = User::factory()->create();

        $minhaVaga = $this->criarVaga($usuario, ['empresa' => 'Minha Empresa']);
        $this->criarVaga($outroUsuario, ['empresa' => 'Empresa Alheia']);

        $response = $this->actingAs($usuario)->get(route('home'));

        $response->assertOk();
        $response->assertSee('Minha Empresa');
        $response->assertDontSee('Empresa Alheia');
    }

    #[Test]
    public function usuario_nao_consegue_acessar_tela_de_edicao_de_vaga_de_outro_usuario()
    {
        $dono = User::factory()->create();
        $invasor = User::factory()->create();

        $vaga = $this->criarVaga($dono);

        $response = $this->actingAs($invasor)->get(route('editar_vaga', $vaga));

        $response->assertForbidden();
    }

    #[Test]
    public function usuario_consegue_acessar_tela_de_edicao_da_propria_vaga()
    {
        $dono = User::factory()->create();
        $vaga = $this->criarVaga($dono);

        $response = $this->actingAs($dono)->get(route('editar_vaga', $vaga));

        $response->assertOk();
    }

    #[Test]
    public function usuario_nao_consegue_atualizar_vaga_de_outro_usuario()
    {
        $dono = User::factory()->create();
        $invasor = User::factory()->create();

        $vaga = $this->criarVaga($dono, ['empresa' => 'Empresa Original']);

        $response = $this->actingAs($invasor)->post(route('editar_vagaSubmit', $vaga), [
            'empresa'   => 'Empresa Hackeada',
            'cargo'     => 'Cargo Hackeado',
            'link_vaga' => 'https://exemplo.com/vaga',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('vagas', [
            'id'      => $vaga->id,
            'empresa' => 'Empresa Original',
        ]);
    }

    #[Test]
    public function usuario_consegue_atualizar_a_propria_vaga()
    {
        $dono = User::factory()->create();
        $vaga = $this->criarVaga($dono, ['empresa' => 'Empresa Original']);

        $response = $this->actingAs($dono)->post(route('editar_vagaSubmit', $vaga), [
            'empresa'   => 'Empresa Atualizada',
            'cargo'     => 'Cargo Atualizado',
            'link_vaga' => 'https://exemplo.com/vaga',
            'status'    => 'aplicado', 
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('vagas', [
            'id'      => $vaga->id,
            'empresa' => 'Empresa Atualizada',
        ]);
    }

    #[Test]
    public function usuario_nao_consegue_apagar_vaga_de_outro_usuario()
    {
        $dono = User::factory()->create();
        $invasor = User::factory()->create();

        $vaga = $this->criarVaga($dono);

        $response = $this->actingAs($invasor)->delete(route('deletar_vaga', $vaga));

        $response->assertForbidden();
        $this->assertDatabaseHas('vagas', ['id' => $vaga->id]);
    }

    #[Test]
    public function usuario_consegue_apagar_a_propria_vaga()
    {
        $dono = User::factory()->create();
        $vaga = $this->criarVaga($dono);

        $response = $this->actingAs($dono)->delete(route('deletar_vaga', $vaga));

        $response->assertRedirect(route('home'));
        $this->assertDatabaseMissing('vagas', ['id' => $vaga->id]);
    }

    #[Test]
    public function usuario_nao_autenticado_e_redirecionado_para_login()
    {
        $vaga = $this->criarVaga(User::factory()->create());

        $response = $this->get(route('editar_vaga', $vaga));

        $response->assertRedirect(route('login'));
    }
}
