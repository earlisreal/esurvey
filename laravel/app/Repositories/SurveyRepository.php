<?php

namespace App\Repositories;

use App\User;

class SurveyRepository
{

    public function forUser(User $user)
    {
        return $user->surveys()
            ->orderBy('updated_at', 'asc')
            ->get();
    }

}