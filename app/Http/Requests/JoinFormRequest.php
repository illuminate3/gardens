<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinFormRequest extends FormRequest
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
        return ['firstname'=>'required',
        'lastname'=>'required',
        'email'=>'required|email|unique:users,email',
        'phone'=>'required',
        'address'=>'required',
        'interest' => 'regex:/^$/i',
            //
        ];
    }
    public function messages()
    {
        return array(
            'email.required' => 'The email address is required.',
           
        );
    }
}
