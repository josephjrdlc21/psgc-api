<?php

namespace App\Laravel\Transformers;

use App\Laravel\Models\PSGCProvince;

use App\Laravel\Traits\ResponseGenerator;

use League\Fractal\TransformerAbstract;

class PSGCProvinceTransformer extends TransformerAbstract{
    use ResponseGenerator;

    public function __construct(){

    }

    public function transform(PSGCProvince $province){
        return [
            'id' => $province->id,
            'region_code' => $province->region_code,
            'province_sku' => $province->province_sku,
            'province_code' => $province->province_code,
            'province_desc' => $province->province_desc,
            'province_status' => $province->province_status,
            'created_at' => $province->created_at?->toDateTimeString(),
            'updated_at' => $province->updated_at?->toDateTimeString(),
            'deleted_at' => $province->deleted_at?->toDateTimeString(),
        ];
    }
}
