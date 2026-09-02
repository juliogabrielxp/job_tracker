<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu perfil - Job Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand navbar-light bg-white border-bottom shadow-sm">
    <div class="container" style="max-width: 640px;">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">
          Job Tracker
        </a>
    </div>
</nav>

<div class="container py-5" style="max-width: 640px;">

    <div class="mb-4">
        <h1 class="h4 fw-semibold mb-1">Meu perfil</h1>
        <p class="text-muted small mb-0">Gerencie as informações da sua conta.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show">
            Dados atualizados com sucesso.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success alert-dismissible fade show">
            Senha atualizada com sucesso.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Dados da conta -->
    <div class="card border shadow-none mb-4">
        <div class="card-body p-4">
            <h2 class="h6 fw-semibold mb-1">Informações do perfil</h2>
            <p class="text-muted small mb-3">Atualize seu nome e endereço de email.</p>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 small">
                            <p class="text-warning mb-1">
                                Seu email ainda não foi verificado.
                            </p>
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 small">
                                    Clique aqui para reenviar o email de verificação.
                                </button>
                            </form>

                            @if (session('status') === 'verification-link-sent')
                                <p class="text-success mt-1 mb-0">
                                    Um novo link de verificação foi enviado para seu email.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Trocar senha -->
    <div class="card border shadow-none mb-4">
        <div class="card-body p-4">
            <h2 class="h6 fw-semibold mb-1">Alterar senha</h2>
            <p class="text-muted small mb-3">Use uma senha longa e segura para manter sua conta protegida.</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Senha atual</label>
                    <input
                        type="password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                        id="current_password"
                        name="current_password"
                        autocomplete="current-password"
                    >
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nova senha</label>
                    <input
                        type="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                    >
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar nova senha</label>
                    <input
                        type="password"
                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                    >
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-key"></i> Atualizar senha
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Excluir conta -->
    <div class="card border border-danger-subtle shadow-none mb-4">
        <div class="card-body p-4">
            <h2 class="h6 fw-semibold mb-1 text-danger">Excluir conta</h2>
            <p class="text-muted small mb-3">
                Depois que sua conta for excluída, todos os seus dados, incluindo as vagas cadastradas, serão apagados permanentemente. Baixe qualquer informação que queira manter antes de continuar.
            </p>

            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                <i class="bi bi-trash"></i> Excluir conta
            </button>
        </div>
    </div>

</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title">Tem certeza que deseja excluir sua conta?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">
                        Essa ação não pode ser desfeita. Digite sua senha para confirmar que deseja excluir permanentemente sua conta.
                    </p>

                    <label for="password_delete" class="form-label">Senha</label>
                    <input
                        type="password"
                        class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                        id="password_delete"
                        name="password"
                        placeholder="Sua senha"
                    >
                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir conta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
