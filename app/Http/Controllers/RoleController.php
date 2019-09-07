<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    public function submit(Request $request){
        $this->validate($request, [
            'name' => 'required',
            ]);
            Role::create($request->all());
            return redirect()->route('roles')->with('status', 'Rol creado con éxito.');
    }
}
