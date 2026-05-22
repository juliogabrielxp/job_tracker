<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Vaga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 640px;">

    <div class="mb-4">
        <h1 class="h4 fw-semibold mb-1">Cadastrar Vaga</h1>
        <p class="text-muted small mb-0">Preencha as informações da vaga para acompanhar seu processo seletivo.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border shadow-none">
        <div class="card-body p-4">
            <form action="{{ route('cadastrar_vagaSubmit') }}" method="POST">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="empresa" class="form-label">Empresa <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control @error('empresa') is-invalid @enderror"
                            id="empresa"
                            name="empresa"
                            placeholder="Ex: Google, Nubank"
                            value="{{ old('empresa') }}"
                        >
                        @error('empresa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control @error('cargo') is-invalid @enderror"
                            id="cargo"
                            name="cargo"
                            placeholder="Ex: Dev PHP Júnior"
                            value="{{ old('cargo') }}"
                        >
                        @error('cargo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="link_vaga" class="form-label">Link da vaga <span class="text-danger">*</span></label>
                    <input
                        type="url"
                        class="form-control @error('link_vaga') is-invalid @enderror"
                        id="link_vaga"
                        name="link_vaga"
                        placeholder="https://linkedin.com/jobs/..."
                        value="{{ old('link_vaga') }}"
                    >
                    @error('link_vaga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="anotacoes" class="form-label">Anotações</label>
                    <textarea
                        class="form-control @error('anotacoes') is-invalid @enderror"
                        id="anotacoes"
                        name="anotacoes"
                        rows="4"
                        placeholder="Contato do recrutador, etapas do processo, salário..."
                    >{{ old('anotacoes') }}</textarea>
                    @error('anotacoes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-3">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy"></i> Salvar vaga
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

</body>
</html>
