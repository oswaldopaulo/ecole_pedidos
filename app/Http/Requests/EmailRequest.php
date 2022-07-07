<?php

namespace pedidos\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
    	return [
    			
    			'tipo'=>'required|max:191',
    			'servidor'=>'required|max:191',
    			'porta'=>'required|max:191',
    			'caixa'=>'required|max:191',
    			'email'=>'required|max:191',
    			'senha'=>'max:191',
    			'csenha'=>'same:senha'
    		
    			
    			
    	];
    }
}
