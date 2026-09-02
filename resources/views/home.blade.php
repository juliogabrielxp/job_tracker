<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand navbar-light bg-white border-bottom shadow-sm">
    <div class="container" style="max-width: 860px;">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">
            Job Tracker
        </a>

        <div class="dropdown ms-auto">
            <button class="btn dropdown-toggle d-flex align-items-center gap-1"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-gear me-2"></i> Perfil
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Sair
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 860px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <p class="text-muted small mb-0">Acompanhe suas candidaturas em um só lugar.</p>
        </div>
        <a href="{{ route('cadastrar_vaga') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nova vaga
        </a>
    </div>
    @php
    $etapas = [
        'aplicado'     => ['label' => 'Aplicado',      'cor' => 'secondary', 'pct' => 20],
        'em_andamento' => ['label' => 'Em andamento',  'cor' => 'primary',   'pct' => 40],
        'entrevista'   => ['label' => 'Entrevista',    'cor' => 'warning',   'pct' => 70],
        'aprovado'     => ['label' => 'Aprovado',      'cor' => 'success',   'pct' => 100],
        'reprovado'    => ['label' => 'Reprovado',     'cor' => 'danger',    'pct' => 100],
    ];
@endphp
<div class="row g-3">
    @foreach($vagas as $vaga)
        @php
            $e = $etapas[$vaga['status']] ?? ['label' => $vaga['status'], 'cor' => 'secondary', 'pct' => 0];
        @endphp
        <div class="col-12">
            <div class="card border shadow-none">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <p class="fw-semibold mb-0">{{ $vaga['empresa'] }}</p>
                            <p class="text-muted small mb-0">{{ $vaga['cargo'] }}</p>
                            @if($vaga['anotacoes'])
                              <p class="text-muted small mt-1 mb-0">
                                  <i class="bi bi-journal-text"></i> {{ $vaga['anotacoes'] }}
                              </p>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <span class="text-muted small me-2">{{ date('d/m/Y', strtotime($vaga['created_at'])) }}</span>
                            <a href="{{ $vaga['link_vaga'] }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-secondary"
                                title="Ver vaga">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <a href="{{ route('editar_vaga', $vaga['id']) }}"
                                class="btn btn-sm btn-outline-primary"
                                title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('deletar_vaga', $vaga['id']) }}"
                                method="POST"
                                onsubmit="return confirm('Deseja realmente remover a vaga de {{ $vaga['cargo'] }} na {{ $vaga['empresa'] }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Remover">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    {{-- Barra de progresso --}}
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge text-bg-{{ $e['cor'] }}">{{ $e['label'] }}</span>
                            <span class="text-muted small">{{ $e['pct'] }}%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-{{ $e['cor'] }}"
                                role="progressbar"
                                style="width: {{ $e['pct'] }}%"
                                aria-valuenow="{{ $e['pct'] }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        {{-- Etapas --}}
                        <div class="d-flex justify-content-between mt-1">
                            <span class="small text-muted">Aplicado</span>
                            <span class="small text-muted">Em andamento</span>
                            <span class="small text-muted">Entrevista</span>
                            <span class="small text-muted">Concluído</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
    <p class="text-muted small mt-2">{{ $vagas->count() }} vaga(s) cadastrada(s).</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
