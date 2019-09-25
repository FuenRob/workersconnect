<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{
    public function submit(Request $request){
        
        $companies = Company::all();
        foreach($companies as $company){
            if(strtoupper($request->cif) ==  strtoupper($company->cif))
                return redirect()->route('register-company')->with('error', 'CIF ya registrado, ponte en contacto con el administrador.')->withInput($request->input());
        }
        $this->validate($request, [
            'name' => 'required',
            'cif' => 'required',
            ]);
            $id_company = Company::create($request->all());
            return redirect()->route('register', ['id_company' => $id_company])->with('status', 'Empresa creada con éxito.');
    }
}
