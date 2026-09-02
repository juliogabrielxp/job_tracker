<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vaga;

class VagaPolicy
{
    public function view(User $user, Vaga $vaga): bool
    {
        return $user->id === $vaga->user_id;
    }

    public function update(User $user, Vaga $vaga): bool
    {
        return $user->id === $vaga->user_id;
    }

    public function delete(User $user, Vaga $vaga): bool
    {
        return $user->id === $vaga->user_id;
    }
}
