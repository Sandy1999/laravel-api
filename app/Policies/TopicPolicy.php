<?php

namespace App\Policies;

use App\User;
use App\Title;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Title $title)
    {
         return $user->ownsTopic($title);
    }
    public function destroy(User $user, Title $title)
    {
         return $user->ownsTopic($title);
    }
}
