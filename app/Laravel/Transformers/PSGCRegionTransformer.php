<?php

namespace App\Laravel\Transformers;

use App\Laravel\Models\PSGCRegion;

use App\Laravel\Traits\ResponseGenerator;

use League\Fractal\TransformerAbstract;

class PSGCRegionTransformer extends TransformerAbstract{
    use ResponseGenerator;

    public function __construct(){

    }

    public function transform(PSGCRegion $region){
        return [
            'id' => $region->id,
            'region_code' => $region->region_code,
            'region_desc' => $region->region_desc,
            'region_status' => $region->region_status,
            'created_at' => $region->created_at?->toDateTimeString(),
            'updated_at' => $region->updated_at?->toDateTimeString(),
            'deleted_at' => $region->deleted_at?->toDateTimeString(),
        ];
    }
}
