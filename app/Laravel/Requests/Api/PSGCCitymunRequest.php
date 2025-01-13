<?php

namespace App\Laravel\Requests\Api;

use App\Laravel\Requests\ApiRequestManager;

class PSGCCitymunRequest extends ApiRequestManager
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
            'region_code' => "required|is_region_code",
            'province_code' => "required|is_province_code",
            'citymun_sku' => "required",
            'citymun_code' => "required|unique:psgc_citymuns,citymun_code,{$id},id",
            'citymun_desc' => "required",
            'citymun_status' => "required"
        ];

        if($id > 0){
            $rules['citymun_code'] = "nullable|unique:psgc_citymuns,citymun_code,{$id},id";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Field is required.",
            'is_region_code' => "This region does not exist.",
            'is_province_code' => "This province does not exist."
        ];
    }
}