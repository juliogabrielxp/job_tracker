<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class VagaStatusUnitTest extends TestCase
{
    // Lógica pura de validação de etapas (espelho do controller)
    private function podeMudarStatus(string $atual, string $novo): bool
    {
        $ordem = [
            'aplicado'     => 1,
            'em_andamento' => 2,
            'entrevista'   => 3,
            'aprovado'     => 4,
            'reprovado'    => 4,
        ];

        if ($novo === 'reprovado') return true;

        $nivelAtual = $ordem[$atual];
        $nivelNovo  = $ordem[$novo];

        return $nivelNovo === $nivelAtual + 1;
    }

    // ✅ Avanços válidos
    public function test_aplicado_pode_ir_para_em_andamento(): void
    {
        $this->assertTrue($this->podeMudarStatus('aplicado', 'em_andamento'));
    }

    public function test_em_andamento_pode_ir_para_entrevista(): void
    {
        $this->assertTrue($this->podeMudarStatus('em_andamento', 'entrevista'));
    }

    public function test_entrevista_pode_ir_para_aprovado(): void
    {
        $this->assertTrue($this->podeMudarStatus('entrevista', 'aprovado'));
    }

    // ✅ Reprovado pode vir de qualquer etapa
    public function test_pode_reprovar_em_aplicado(): void
    {
        $this->assertTrue($this->podeMudarStatus('aplicado', 'reprovado'));
    }

    public function test_pode_reprovar_em_andamento(): void
    {
        $this->assertTrue($this->podeMudarStatus('em_andamento', 'reprovado'));
    }

    public function test_pode_reprovar_em_entrevista(): void
    {
        $this->assertTrue($this->podeMudarStatus('entrevista', 'reprovado'));
    }

    // ❌ Não pode voltar etapa
    public function test_nao_pode_voltar_de_em_andamento_para_aplicado(): void
    {
        $this->assertFalse($this->podeMudarStatus('em_andamento', 'aplicado'));
    }

    public function test_nao_pode_voltar_de_entrevista_para_em_andamento(): void
    {
        $this->assertFalse($this->podeMudarStatus('entrevista', 'em_andamento'));
    }

    public function test_nao_pode_voltar_de_aprovado_para_entrevista(): void
    {
        $this->assertFalse($this->podeMudarStatus('aprovado', 'entrevista'));
    }

    // ❌ Não pode pular etapa
    public function test_nao_pode_pular_de_aplicado_para_entrevista(): void
    {
        $this->assertFalse($this->podeMudarStatus('aplicado', 'entrevista'));
    }

    public function test_nao_pode_pular_de_aplicado_para_aprovado(): void
    {
        $this->assertFalse($this->podeMudarStatus('aplicado', 'aprovado'));
    }

    public function test_nao_pode_pular_de_em_andamento_para_aprovado(): void
    {
        $this->assertFalse($this->podeMudarStatus('em_andamento', 'aprovado'));
    }
}
