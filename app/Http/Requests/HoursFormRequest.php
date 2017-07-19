<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HoursFormRequest extends FormRequest
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
        'servicedate' => 'required|date',
        'starttime' =>'required_without_all:hours,endtime|date_format:g:i A',
        'endtime'=>'required_without_all:hours,starttime|date_format:g:i A|after:starttime',
        'hours'=>"required_without_all:starttime,endtime",
        'description'=>'required'
        ];
    }
}
