<?php

namespace App\Laravel\Requests\Api;

use App\Laravel\Requests\ApiRequestManager;

class PSGCBarangayRequest extends ApiRequestManager
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
            'citymun_code' => "required|is_citymun_code",
            'barangay_code' => "required|unique:psgc_barangays,barangay_code,{$id},barangay_code",
            'barangay_desc' => "required",
            'zipcode' => "required",
            'barangay_status' => "required"
        ];

        if($id > 0){
            $rules['barangay_code'] = "nullable|unique:psgc_barangays,barangay_code,{$id},barangay_code";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Field is required.",
            'is_region_code' => "This region does not exist.",
            'is_province_code' => "This province does not exist.",
            'is_citymun_code' => "This citymun does not exist."
        ];
    }
}