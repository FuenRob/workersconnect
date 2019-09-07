<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{
    public function submit(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'cif' => 'required',
            ]);
            $id_company = Company::create($request->all());
            return redirect()->route('register', ['id_company' => $id_company])->with('status', 'Empresa creada con éxito.');
    }
}
