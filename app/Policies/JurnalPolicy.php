<?php

namespace App\Policies;

use App\Models\Jurnal;
use App\Models\User;

class JurnalPolicy
{
    public function view(User $user, Jurnal $jurnal): bool
    {
        return (int) $user->id === (int) $jurnal->id_user;
    }

    public function update(User $user, Jurnal $jurnal): bool
    {
        return $this->view($user, $jurnal);
    }

    public function delete(User $user, Jurnal $jurnal): bool
    {
        return $this->view($user, $jurnal);
    }
}