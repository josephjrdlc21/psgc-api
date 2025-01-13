<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCProvince;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Api\PSGCProvinceRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCProvinceTransformer;
use App\Laravel\Transformers\TransformerManager;

use DB;

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

    public function store(PSGCProvinceRequest $request){
        DB::beginTransaction();
        try{
            $province = new PSGCProvince;
            $province->region_code = $request->input('region_code');
            $province->province_sku = strtoupper($request->input('province_sku'));
            $province->province_code = $request->input('province_code');
            $province->province_desc = strtoupper($request->input('province_desc'));
            $province->province_status = strtolower($request->input('province_status'));
            $province->save();

            DB::commit();

            $this->response['status'] = true;
            $this->response['status_code'] = "PROVINCE_CREATED";
            $this->response['msg'] = "Province has been successfully created.";
            $this->response['data'] = $this->transformer->transform($province, new PSGCProvinceTransformer(), 'item');
            $this->response_code = 201;
            goto callback;
        }catch(\Exception $e){
            DB::rollback();

            $this->response['status'] = false;
            $this->response['status_code'] = "FAILED";
            $this->response['msg'] = "Unable to create province.";
            $this->response_code = 403;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function update(PSGCProvinceRequest $request,$id = null){
        $province = PSGCProvince::where('province_code', $id)->first();

        if(!$province){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        DB::beginTransaction();
        try{
            $province->region_code = $request->input('region_code');
            $province->province_sku = strtoupper($request->input('province_sku'));
            $province->province_desc = strtoupper($request->input('province_desc'));
            $province->province_status = strtolower($request->input('province_status'));
            $province->save();

            DB::commit();

            $this->response['status'] = true;
            $this->response['status_code'] = "PROVINCE_UPDATED";
            $this->response['msg'] = "Province has been successfully updated.";
            $this->response['data'] = $this->transformer->transform($province, new PSGCProvinceTransformer(), 'item');
            $this->response_code = 200;
            goto callback;
        }catch(\Exception $e){
            DB::rollback();

            $this->response['status'] = false;
            $this->response['status_code'] = "FAILED";
            $this->response['msg'] = "Unable to update province.";
            $this->response_code = 403;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function destroy(PageRequest $request,$id = null){
        $province = PSGCProvince::where('province_code', $id)->first();

        if(!$province){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        if($province->delete()){
            $this->response['status'] = true;
            $this->response['status_code'] = "PROVINCE_DELETED";
            $this->response['msg'] = "Province has been successfully deleted.";
            $this->response['data'] = $this->transformer->transform($province, new PSGCProvinceTransformer(), 'item');
            $this->response_code = 200;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function show(PageRequest $request,$id = null){
        $province = PSGCProvince::where('province_code', $id)->where('province_status', 'active')->first();

        if(!$province){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        $this->response['status'] = true;
        $this->response['status_code'] = "SHOW_PROVINCE";
        $this->response['msg'] = "Show PROVINCE";
        $this->response['data'] = $this->transformer->transform($province, new PSGCProvinceTransformer(), 'item');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}