<?php

namespace App\Laravel\Requests\Api;

use App\Laravel\Requests\ApiRequestManager;

class PSGCProvinceRequest extends ApiRequestManager
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
            'province_sku' => "required",
            'province_code' => "required|unique:psgc_provinces,province_code,{$id},id",
            'province_desc' => "required",
            'province_status' => "required",
        ];

        if($id > 0){
            $rules['province_code'] = "nullable|unique:psgc_provinces,province_code,{$id},id";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Field is required.",
            'is_region_code' => "This region does not exist."
        ];
    }
}