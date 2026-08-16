<?php

namespace App\Providers;

use App\Models\Idea;
use App\Policies\IdeaPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Idea::class, IdeaPolicy::class);

        // O Laravel usa a view de paginação em Tailwind por padrão (com ícones
        // SVG que ficam enormes/sem estilo sem o Tailwind carregado). Como o
        // projeto usa Bootstrap 5, forçamos a view de paginação do Bootstrap
        // (as classes .pagination/.page-item/.page-link são as mesmas no
        // Bootstrap 4 e 5, então essa view funciona perfeitamente aqui).
        Paginator::useBootstrapFour();
    }
}
