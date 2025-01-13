<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCCitymun;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Api\PSGCCitymunRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCCitymunTransformer;
use App\Laravel\Transformers\TransformerManager;

use DB;

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

    public function store(PSGCCitymunRequest $request){
        DB::beginTransaction();
        try{
            $citymun = new PSGCCitymun;
            $citymun->region_code = $request->input('region_code');
            $citymun->province_code = $request->input('province_code');
            $citymun->citymun_sku = strtoupper($request->input('citymun_sku'));
            $citymun->citymun_code = $request->input('citymun_code');
            $citymun->citymun_desc = strtoupper($request->input('citymun_desc'));
            $citymun->citymun_status = strtolower($request->input('citymun_status'));
            $citymun->save();

            DB::commit();

            $this->response['status'] = true;
            $this->response['status_code'] = "CITYMUN_CREATED";
            $this->response['msg'] = "Citymun has been successfully created.";
            $this->response['data'] = $this->transformer->transform($citymun, new PSGCCitymunTransformer(), 'item');
            $this->response_code = 201;
            goto callback;
        }catch(\Exception $e){
            DB::rollback();

            $this->response['status'] = false;
            $this->response['status_code'] = "FAILED";
            $this->response['msg'] = "Unable to create citymun.";
            $this->response_code = 403;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function update(PSGCCitymunRequest $request,$id = null){
        $citymun = PSGCCitymun::where('citymun_code', $id)->first();

        if(!$citymun){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        DB::beginTransaction();
        try{
            $citymun->region_code = $request->input('region_code');
            $citymun->province_code = $request->input('province_code');
            $citymun->citymun_sku = strtoupper($request->input('citymun_sku'));
            $citymun->citymun_desc = strtoupper($request->input('citymun_desc'));
            $citymun->citymun_status = strtolower($request->input('citymun_status'));
            $citymun->save();

            DB::commit();

            $this->response['status'] = true;
            $this->response['status_code'] = "CITYMUN_UPDATED";
            $this->response['msg'] = "Citymun has been successfully updated.";
            $this->response['data'] = $this->transformer->transform($citymun, new PSGCCitymunTransformer(), 'item');
            $this->response_code = 200;
            goto callback;
        }catch(\Exception $e){
            DB::rollback();

            $this->response['status'] = false;
            $this->response['status_code'] = "FAILED";
            $this->response['msg'] = "Unable to update citymun.";
            $this->response_code = 403;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function destroy(PageRequest $request,$id = null){
        $citymun = PSGCCitymun::where('province_code', $id)->first();

        if(!$citymun){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        if($citymun->delete()){
            $this->response['status'] = true;
            $this->response['status_code'] = "CITYMUN_DELETED";
            $this->response['msg'] = "Citymun has been successfully deleted.";
            $this->response['data'] = $this->transformer->transform($citymun, new PSGCCitymunTransformer(), 'item');
            $this->response_code = 200;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function show(PageRequest $request,$id = null){
        $citymun = PSGCCitymun::where('citymun_code', $id)->where('citymun_status', 'active')->first();

        if(!$citymun){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        $this->response['status'] = true;
        $this->response['status_code'] = "SHOW_CITYMUN";
        $this->response['msg'] = "Show CITYMUN";
        $this->response['data'] = $this->transformer->transform($citymun, new PSGCCitymunTransformer(), 'item');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}