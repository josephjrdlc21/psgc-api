<?php

namespace App\Laravel\Transformers;

use App\Laravel\Models\PSGCBarangay;

use App\Laravel\Traits\ResponseGenerator;

use League\Fractal\TransformerAbstract;

class PSGCBarangayTransformer extends TransformerAbstract{
    use ResponseGenerator;

    public function __construct(){

    }

    public function transform(PSGCBarangay $barangay){
        return [
            'id' => $barangay->id,
            'region_code' => $barangay->region_code,
            'province_code' => $barangay->province_code,
            'citymun_code' => $barangay->citymun_code,
            'barangay_code' => $barangay->barangay_code,
            'barangay_desc' => $barangay->barangay_desc,
            'zipcode' => $barangay->zipcode,
            'barangay_status' => $barangay->barangay_status,
            'created_at' => $barangay->created_at?->toDateTimeString(),
            'updated_at' => $barangay->updated_at?->toDateTimeString(),
            'deleted_at' => $barangay->deleted_at?->toDateTimeString(),
        ];
    }
}
