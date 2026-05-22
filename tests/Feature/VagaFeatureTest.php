<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Vaga;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VagaFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function dadosVaga(array $override = []): array
    {
        return array_merge([
            'empresa'   => 'Empresa Teste',
            'cargo'     => 'Dev PHP',
            'link_vaga' => 'https://linkedin.com/jobs/123',
            'anotacoes' => 'Nenhuma.',
            'status'    => 'aplicado',
        ], $override);
    }

    private function criarVaga(string $status = 'aplicado'): Vaga
    {
        return Vaga::create($this->dadosVaga(['status' => $status]));
    }

    // ========================
    // TESTES DE CRIAÇÃO
    // ========================

    public function test_cria_vaga_com_dados_validos(): void
    {
        $response = $this->post(route('cadastrar_vagaSubmit'), $this->dadosVaga());

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('vagas', ['empresa' => 'Empresa Teste', 'cargo' => 'Dev PHP']);
    }

    public function test_nao_cria_vaga_sem_empresa(): void
    {
        $response = $this->post(route('cadastrar_vagaSubmit'), $this->dadosVaga(['empresa' => '']));

        $response->assertSessionHasErrors('empresa');
        $this->assertDatabaseMissing('vagas', ['cargo' => 'Dev PHP']);
    }

    public function test_nao_cria_vaga_sem_cargo(): void
    {
        $response = $this->post(route('cadastrar_vagaSubmit'), $this->dadosVaga(['cargo' => '']));

        $response->assertSessionHasErrors('cargo');
    }

    public function test_nao_cria_vaga_com_link_invalido(): void
    {
        $response = $this->post(route('cadastrar_vagaSubmit'), $this->dadosVaga(['link_vaga' => 'link-invalido']));

        $response->assertSessionHasErrors('link_vaga');
    }

    public function test_cria_vaga_sem_anotacoes(): void
    {
        $response = $this->post(route('cadastrar_vagaSubmit'), $this->dadosVaga(['anotacoes' => null]));

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('vagas', ['empresa' => 'Empresa Teste']);
    }

    // ========================
    // TESTES DE ATUALIZAÇÃO
    // ========================

    public function test_atualiza_vaga_com_dados_validos(): void
    {
        $vaga = $this->criarVaga();

        $response = $this->post(route('editar_vagaSubmit', $vaga->id), $this->dadosVaga([
            'empresa' => 'Nova Empresa',
            'status'  => 'em_andamento',
        ]));

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('vagas', ['id' => $vaga->id, 'empresa' => 'Nova Empresa']);
    }

    public function test_nao_atualiza_vaga_sem_empresa(): void
    {
        $vaga = $this->criarVaga();

        $response = $this->post(route('editar_vagaSubmit', $vaga->id), $this->dadosVaga(['empresa' => '']));

        $response->assertSessionHasErrors('empresa');
    }

    public function test_nao_atualiza_vaga_com_link_invalido(): void
    {
        $vaga = $this->criarVaga();

        $response = $this->post(route('editar_vagaSubmit', $vaga->id), $this->dadosVaga(['link_vaga' => 'nao-e-url']));

        $response->assertSessionHasErrors('link_vaga');
    }

    // ========================
    // TESTES DE ETAPAS
    // ========================

    public function test_avanca_para_proxima_etapa(): void
    {
        $vaga = $this->criarVaga('aplicado');

        $response = $this->post(route('editar_vagaSubmit', $vaga->id), $this->dadosVaga(['status' => 'em_andamento']));

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('vagas', ['id' => $vaga->id, 'status' => 'em_andamento']);
    }

    public function test_nao_pode_voltar_etapa(): void
    {
        $vaga = $this->criarVaga('entrevista');

        $response = $this->post(route('editar_vagaSubmit', $vaga->id), $this->dadosVaga(['status' => 'aplicado']));

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseHas('vagas', ['id' => $vaga->id, 'status' => 'entrevista']);
    }

    public function test_nao_pode_pular_etapa(): void
    {
        $vaga = $this->criarVaga('aplicado');

        $response = $this->post(route('editar_vagaSubmit', $vaga->id), $this->dadosVaga(['status' => 'entrevista']));

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseHas('vagas', ['id' => $vaga->id, 'status' => 'aplicado']);
    }

    public function test_pode_reprovar_em_qualquer_etapa(): void
    {
        $vaga = $this->criarVaga('em_andamento');

        $response = $this->post(route('editar_vagaSubmit', $vaga->id), $this->dadosVaga(['status' => 'reprovado']));

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('vagas', ['id' => $vaga->id, 'status' => 'reprovado']);
    }
}
