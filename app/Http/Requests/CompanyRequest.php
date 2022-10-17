<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
		$unique = Rule::unique('companies');
		
		if(Str::endsWith(Route::currentRouteName(),'.update')){
			$parameter = Route::current()->parameterNames[0];
			$ignore = Route::current()->$parameter;
			$unique->ignore($ignore);
		}
		
        $rules = [
            'title' => ['required',$unique,'string','min:3','max:255'],
            'director' => 'required|string|min:3|max:255',
            'inn' => 'required|string|min:3|max:15',
            'address' => 'required|string|min:3|max:255',
            'phone' => 'required|string|min:3|max:255',
            'description' => 'sometimes',
        ];
		
		return $rules;
    }
}
