<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index',[
            'users'=>User::all(),
            'roles'=>Role::all()
        ]);
    }

    public function assignRole(Request $request, User $user)
    {
        $user->syncRoles([$request->role]);
        return back();
    }
}