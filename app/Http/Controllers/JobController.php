<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaga;

class JobController extends Controller
{
    public function home()
    {
        $vagas =  Vaga::all();

        return view('home', compact('vagas'));
    }

    public function vaga()
    {

        return view('cadastrar_vaga');

    }

    public function vagaSubmit(Request $request)
    {

    $request->validate([
        'empresa'  => 'required|max:255',
        'cargo'    => 'required|max:255',
        'link_vaga' => 'required|url|max:2048',
    ], [
        'empresa.required'  => 'O campo empresa é obrigatório.',
        'empresa.max'       => 'O nome da empresa deve ter no máximo 255 caracteres.',
        'cargo.required'    => 'O campo cargo é obrigatório.',
        'cargo.max'         => 'O cargo deve ter no máximo 255 caracteres.',
        'link_vaga.url'     => 'O link da vaga deve ser uma URL válida.',
        'link_vaga.required' => 'O link da vaga é obrigatório.',
        'link_vaga.max'     => 'O link deve ter no máximo 2048 caracteres.',
    ]);

    $vaga = new Vaga();

    $vaga->empresa = $request->empresa;
    $vaga->cargo = $request->cargo;
    $vaga->link_vaga = $request->link_vaga;
    $vaga->anotacoes = $request->anotacoes;

    $vaga->save();

    return redirect()->route('home');
}

    public function editar($id)
{
    $vaga = Vaga::find($id);
    return view('editar_vaga', compact('vaga'));
}

public function editarSubmit(Request $request, $id)
{
    $request->validate([
        'empresa'   => 'required|max:255',
        'cargo'     => 'required|max:255',
        'link_vaga' => 'required|url|max:2048',
    ], [
        'empresa.required'   => 'O campo empresa é obrigatório.',
        'empresa.max'        => 'O nome da empresa deve ter no máximo 255 caracteres.',
        'cargo.required'     => 'O campo cargo é obrigatório.',
        'cargo.max'          => 'O cargo deve ter no máximo 255 caracteres.',
        'link_vaga.required' => 'O link da vaga é obrigatório.',
        'link_vaga.url'      => 'O link da vaga deve ser uma URL válida.',
        'link_vaga.max'      => 'O link deve ter no máximo 2048 caracteres.',
    ]);

    $ordem = [
        'aplicado'     => 1,
        'em_andamento' => 2,
        'entrevista'   => 3,
        'aprovado'     => 4,
        'reprovado'    => 4,
    ];

    $vaga = Vaga::find($id);

    $nivelAtual = $ordem[$vaga->status];
    $nivelNovo  = $ordem[$request->status];

    // Reprovado pode vir de qualquer etapa
    if ($request->status !== 'reprovado') {

        if ($nivelNovo < $nivelAtual) {
            return back()
                ->withErrors(['status' => 'Não é possível voltar para uma etapa anterior.'])
                ->withInput();
        }

        if ($nivelNovo > $nivelAtual + 1) {
            return back()
                ->withErrors(['status' => 'Não é possível pular etapas do processo.'])
                ->withInput();
        }
    }

    $vaga->empresa   = $request->empresa;
    $vaga->cargo     = $request->cargo;
    $vaga->link_vaga = $request->link_vaga;
    $vaga->anotacoes = $request->anotacoes;
    $vaga->status    = $request->status;
    $vaga->save();

    return redirect()->route('home');
}

    public function deletar($id)
    {

    $vaga = Vaga::find($id);
    $vaga->delete();

    return redirect()->route('home');
    }

}
