<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCRegion;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Api\PSGCRegionRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCRegionTransformer;
use App\Laravel\Transformers\TransformerManager;

use DB;

class PSGCRegionsController extends Controller{
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
        $regions = PSGCRegion::where('region_status', 'active')->get();

        $this->response['status'] = true;
        $this->response['status_code'] = "REGION_LIST";
        $this->response['msg'] = "Available REGIONS list.";
        $this->response['data'] = $this->transformer->transform($regions, new PSGCRegionTransformer(), 'collection');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function show(PageRequest $request,$id = null){
        $regions = PSGCRegion::where('region_code', $id)->where('region_status', 'active')->get();

        $this->response['status'] = true;
        $this->response['status_code'] = "SHOW_REGION";
        $this->response['msg'] = "Show REGION";
        $this->response['data'] = $this->transformer->transform($regions, new PSGCRegionTransformer(), 'collection');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function store(PSGCRegionRequest $request){
        DB::beginTransaction();
        try{
            $region = new PSGCRegion;
            $region->region_code = $request->input('region_code');
            $region->region_desc = strtoupper($request->input('region_desc'));
            $region->region_status = strtolower($request->input('region_status'));
            $region->save();

            DB::commit();

            $this->response['status'] = true;
            $this->response['status_code'] = "REGION_CREATED";
            $this->response['msg'] = "Region has been successfully created.";
            $this->response_code = 201;
            goto callback;
        }catch(\Exception $e){
            DB::rollback();

            $this->response['status'] = false;
            $this->response['status_code'] = "FAILED";
            $this->response['msg'] = "Unable to create region.";
            $this->response_code = 403;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}