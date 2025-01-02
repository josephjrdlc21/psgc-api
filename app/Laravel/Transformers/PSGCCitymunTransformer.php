<?php

namespace App\Laravel\Transformers;

use App\Laravel\Models\PSGCCitymun;

use App\Laravel\Traits\ResponseGenerator;

use League\Fractal\TransformerAbstract;

class PSGCCitymunTransformer extends TransformerAbstract{
    use ResponseGenerator;

    public function __construct(){

    }

    public function transform(PSGCCitymun $citymun){
        return [
            'id' => $citymun->id,
            'region_code' => $citymun->region_code,
            'province_code' => $citymun->province_code,
            'citymun_sku' => $citymun->citymun_sku,
            'citymun_code' => $citymun->citymun_code,
            'citymun_desc' => $citymun->citymun_desc,
            'citymun_status' => $citymun->citymun_status,
            'created_at' => $citymun->created_at?->toDateTimeString(),
            'updated_at' => $citymun->updated_at?->toDateTimeString(),
            'deleted_at' => $citymun->deleted_at?->toDateTimeString(),
        ];
    }
}
