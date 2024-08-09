<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
    public function all()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
