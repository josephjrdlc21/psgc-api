<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCProvince;

use App\Laravel\Requests\PageRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCProvinceTransformer;
use App\Laravel\Transformers\TransformerManager;

class PSGCProvinceController extends Controller{
    use ResponseGenerator;

    protected $transformer;
    protected $data;
    protected $response;
    protected $response_code;

    public function __construct(){
        parent::__construct();
        $this->transformer = new TransformerManager;
        $this->response = ['msg' => "Bad Request.", "status" => false, 'status_code' => "BAD_REQUEST"];
    }

    public function index(PageRequest $request){
        $province = PSGCProvince::where('province_status', 'active')->get();

        $this->response['status'] = true;
        $this->response['status_code'] = "PROVINCE_LIST";
        $this->response['msg'] = "Available PROVINCES list.";
        $this->response['data'] = $this->transformer->transform($province, new PSGCProvinceTransformer(), 'collection');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function show(PageRequest $request,$id = null){
        $province = PSGCProvince::where('province_code', $id)->where('province_status', 'active')->get();

        $this->response['status'] = true;
        $this->response['status_code'] = "SHOW_PROVINCE";
        $this->response['msg'] = "Show PROVINCE";
        $this->response['data'] = $this->transformer->transform($province, new PSGCProvinceTransformer(), 'collection');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}