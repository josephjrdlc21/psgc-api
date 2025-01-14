<?php

namespace App\Laravel\Controllers\Api;

use App\Laravel\Models\PSGCBarangay;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Api\PSGCBarangayRequest;

use App\Laravel\Traits\ResponseGenerator;

use App\Laravel\Transformers\PSGCBarangayTransformer;
use App\Laravel\Transformers\TransformerManager;

use DB;

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

    public function store(PSGCBarangayRequest $request){
        DB::beginTransaction();
        try{
            $barangay = new PSGCBarangay;
            $barangay->region_code = $request->input('region_code');
            $barangay->province_code = $request->input('province_code');
            $barangay->citymun_code = $request->input('citymun_code');
            $barangay->barangay_code = $request->input('barangay_code');
            $barangay->barangay_desc = strtoupper($request->input('barangay_desc'));
            $barangay->zipcode = strtoupper($request->input('zipcode'));
            $barangay->barangay_status = strtolower($request->input('barangay_status'));
            $barangay->save();

            DB::commit();

            $this->response['status'] = true;
            $this->response['status_code'] = "BARANGAY_CREATED";
            $this->response['msg'] = "Barangay has been successfully created.";
            $this->response['data'] = $this->transformer->transform($barangay, new PSGCBarangayTransformer(), 'item');
            $this->response_code = 201;
            goto callback;
        }catch(\Exception $e){
            DB::rollback();

            $this->response['status'] = false;
            $this->response['status_code'] = "FAILED";
            $this->response['msg'] = "Unable to create barangay.";
            $this->response_code = 403;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function update(PSGCBarangayRequest $request,$id = null){
        $barangay = PSGCBarangay::where('barangay_code', $id)->first();

        if(!$barangay){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        DB::beginTransaction();
        try{
            $barangay->region_code = $request->input('region_code');
            $barangay->province_code = $request->input('province_code');
            $barangay->citymun_code = $request->input('citymun_code');
            $barangay->barangay_desc = strtoupper($request->input('barangay_desc'));
            $barangay->zipcode = strtoupper($request->input('zipcode'));
            $barangay->barangay_status = strtolower($request->input('barangay_status'));
            $barangay->save();

            DB::commit();

            $this->response['status'] = true;
            $this->response['status_code'] = "BARANGAY_UPDATED";
            $this->response['msg'] = "Barangay has been successfully updated.";
            $this->response['data'] = $this->transformer->transform($barangay, new PSGCBarangayTransformer(), 'item');
            $this->response_code = 200;
            goto callback;
        }catch(\Exception $e){
            DB::rollback();

            $this->response['status'] = false;
            $this->response['status_code'] = "FAILED";
            $this->response['msg'] = "Unable to update barangay.";
            $this->response_code = 403;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function destroy(PageRequest $request,$id = null){
        $barangay = PSGCBarangay::where('barangay_code', $id)->first();

        if(!$barangay){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        if($barangay->delete()){
            $this->response['status'] = true;
            $this->response['status_code'] = "BARANGAY_DELETED";
            $this->response['msg'] = "Barangay has been successfully deleted.";
            $this->response['data'] = $this->transformer->transform($barangay, new PSGCBarangayTransformer(), 'item');
            $this->response_code = 200;
            goto callback;
        }

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }

    public function show(PageRequest $request,$id = null){
        $barangay = PSGCBarangay::where('barangay_code', $id)->where('barangay_status', 'active')->first();

        if(!$barangay){
            $error = $this->not_found_error();
            return response()->json($error['body'], $error['code']);  
        }

        $this->response['status'] = true;
        $this->response['status_code'] = "SHOW_BARANGAY";
        $this->response['msg'] = "Show BARANGAY";
        $this->response['data'] = $this->transformer->transform($barangay, new PSGCBarangayTransformer(), 'item');
        $this->response_code = 200;

        callback:
        return response()->json($this->api_response($this->response), $this->response_code);
    }
}