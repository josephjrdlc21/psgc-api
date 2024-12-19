<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCRegion;

use App\Laravel\Requests\PageRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCRegionTransformer;
use App\Laravel\Transformers\TransformerManager;

class PSGCRegionsController extends Controller{
    use ResponseGenerator;

    protected $data;

    public function __construct(){
        parent::__construct();
        $this->transformer = new TransformerManager;
        $this->response = ['msg' => "Bad Request.", "status" => false, 'status_code' => "BAD_REQUEST"];
    }

    public function index(PageRequest $request){
        $regions = PSGCRegion::where('region_status', 'active')->get();

        $this->response['status'] = true;
        $this->response['status_code'] = "REGION_LIST";
        $this->response['msg'] = "Available REGIONS list.";
        $this->response['data'] = $this->transformer->transform($regions, new PSGCRegionTransformer(), 'collection');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}