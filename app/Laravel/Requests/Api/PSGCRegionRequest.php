<?php

namespace App\Laravel\Requests\Api;

use App\Laravel\Requests\ApiRequestManager;

class PSGCRegionRequest extends ApiRequestManager
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
            'region_code' => "required|unique:psgc_regions,region_code,{$id},id",
            'region_desc' => "required",
            'region_status' => "required"
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Field is required."
        ];
    }
}