<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use App\Models\Role;
use App\Models\User;

class AuthUser
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function isAuthorized()
    {

        if (auth()->user()) {
            return true;
        }
        return false;
    }

    public function Role()
    {
        $u = new User();
        $user = $u->find(auth()->user()->id);
        $role = $user->role;

        return $role;
    }

    public function isAdmin()
    {

        if (auth()->user()->role == 'مدير') {
            return true;
        }
        return false;
    }
}
