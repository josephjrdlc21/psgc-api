<?php

namespace Database\Seeders;

use App\Laravel\Models\PSGCProvince;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class PSGCProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PSGCProvince::truncate();
        
        $json = file_get_contents(__DIR__ . '/json/province.json');
        $data = json_decode($json);
        $provinces = [];
        
        foreach ($data as $row) {
            if($row->province_status == "1"){
                $provinces[] = array(
                    'region_code' => $row->region_code,
                    'province_sku' => $row->province_sku,
                    'province_code' => $row->province_code,
                    'province_desc' => $row->province_desc,
                    'province_status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                );
            }
            
        }
        foreach (array_chunk($provinces, 500) as $provinces_batch) {
            PSGCProvince::insert($provinces_batch);
        }
    }
}
