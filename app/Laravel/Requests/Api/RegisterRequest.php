<?php

namespace App\Laravel\Requests\Api;

use App\Laravel\Requests\ApiRequestManager;

class RegisterRequest extends ApiRequestManager
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
        $id = $this->id ?? 0;

        $rules = [
            'name' => "required",
            'email' => "required|email:rfc,dns|unique:users,email,{$id},id",
            'password' => "required|password_format"
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Field is required.",
            'password_format' => "Password should aleast 8 charateres and contain 1 uppercase, 1 lowercase, 1 numeric and 1 special character."
        ];
    }
}