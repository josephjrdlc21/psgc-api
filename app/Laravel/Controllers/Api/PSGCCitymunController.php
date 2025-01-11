<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCCitymun;

use App\Laravel\Requests\PageRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCCitymunTransformer;
use App\Laravel\Transformers\TransformerManager;

class PSGCCitymunController extends Controller{
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
        $citymun = PSGCCitymun::where('citymun_status', 'active')->get();

        $this->response['status'] = true;
        $this->response['status_code'] = "CITYMUN_LIST";
        $this->response['msg'] = "Available CITIES list.";
        $this->response['data'] = $this->transformer->transform($citymun, new PSGCCitymunTransformer(), 'collection');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function show(PageRequest $request,$id = null){
        $citymun = PSGCCitymun::where('citymun_code', $id)->where('citymun_status', 'active')->first();

        $this->response['status'] = true;
        $this->response['status_code'] = "SHOW_CITYMUN";
        $this->response['msg'] = "Show CITYMUN";
        $this->response['data'] = $this->transformer->transform($citymun, new PSGCCitymunTransformer(), 'item');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}