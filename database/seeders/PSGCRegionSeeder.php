<?php

namespace Database\Seeders;

use App\Laravel\Models\PSGCRegion;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class PSGCRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PSGCRegion::truncate();
        
        $json = file_get_contents(__DIR__ . '/json/region.json');
        $data = json_decode($json);
        $regions = [];
        
        foreach ($data as $row) {

            if($row->region_status == "1"){
                $regions[] = array(
                    'region_code' => $row->region_code,
                    'region_desc' => $row->region_desc,
                    'region_status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                );
            }
            
        }
        foreach (array_chunk($regions, 500) as $regions_batch) {
            PSGCRegion::insert($regions_batch);
        }
    }
}
