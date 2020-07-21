<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;

class UserController extends Controller
{
    public function getList()
    {
        return new UserResource(User::query()->get());
    }
}
