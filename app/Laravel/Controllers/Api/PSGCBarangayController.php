<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCBarangay;

use App\Laravel\Requests\PageRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCBarangayTransformer;
use App\Laravel\Transformers\TransformerManager;

class PSGCBarangayController extends Controller{
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
        $barangay = PSGCBarangay::where('barangay_status', 'active')->get();

        $this->response['status'] = true;
        $this->response['status_code'] = "BARANGAY_LIST";
        $this->response['msg'] = "Available BARANGAY list.";
        $this->response['data'] = $this->transformer->transform($barangay, new PSGCBarangayTransformer(), 'collection');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function show(PageRequest $request,$id = null){
        $barangay = PSGCBarangay::where('barangay_code', $id)->where('barangay_status', 'active')->first();

        $this->response['status'] = true;
        $this->response['status_code'] = "SHOW_BARANGAY";
        $this->response['msg'] = "Show BARANGAY";
        $this->response['data'] = $this->transformer->transform($barangay, new PSGCBarangayTransformer(), 'item');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}