<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function searchUser(Request $request)
    {
        $name = $request?->query('name');

        $users = User::where('name', 'like', $name.'%')->get();
        return $users;
//        $email = $request?->query('email');
    }
}
