<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.index',[
		    'companies' => Company::all(),
		]);
    }
	
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
		$company->load('comments');
		$company->comments = $company->comments->groupBy('field');

        return view('company.show',[
		    'company' => $company,
		]);
    }
}
