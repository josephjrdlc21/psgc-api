<?php

namespace App\Laravel\Services;

use App\Laravel\Models\{User,PSGCRegion,PSGCProvince,PSGCCitymun};

use Illuminate\Validation\Validator;

use Hash;

class CustomValidator extends Validator
{
    public function validateIsRegionCode($attribute, $value, $parameters){
        $is_region_code = PSGCRegion::where('region_code', $value)->first();

        return $is_region_code ? true : false;
    }

    public function validateIsProvinceCode($attribute, $value, $parameters){
        $is_province_code = PSGCProvince::where('province_code', $value)->first();

        return $is_province_code ? true : false;
    }
}
