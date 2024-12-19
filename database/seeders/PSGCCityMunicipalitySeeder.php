<?php

namespace Database\Seeders;

use App\Laravel\Models\PSGCCitymun;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class PSGCCityMunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PSGCCitymun::truncate();
        
        $json = file_get_contents(__DIR__ . '/json/municipality.json');
        $data = json_decode($json);
        $citymuns = [];
        
        foreach ($data as $row) {
            $citymuns[] = array(
                'region_code' => $row->region_code,
                'province_code' => $row->province_code,
                'citymun_sku' => $row->municipality_sku,
                'citymun_code' => $row->municipality_code,
                'citymun_desc' => $row->municipality_desc,
                'citymun_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            );
        }
        foreach (array_chunk($citymuns, 500) as $citymuns_batch) {
            PSGCCitymun::insert($citymuns_batch);
        }
    }
}
