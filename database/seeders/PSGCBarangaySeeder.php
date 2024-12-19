<?php

namespace Database\Seeders;

use App\Laravel\Models\PSGCBarangay;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class PSGCBarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PSGCBarangay::truncate();
        
        $json = file_get_contents(__DIR__ . '/json/barangay.json');
        $data = json_decode($json);
        $barangays = [];
        
        foreach ($data as $row) {
            $barangays[] = array(
                'region_code' => $row->region_code,
                'province_code' => $row->province_code,
                'citymun_code' => $row->municipality_code,
                'barangay_code' => $row->barangay_code,
                'barangay_desc' => $row->barangay_desc,
                'zipcode' => trim($row->zipcode),
                'barangay_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            );
            
        }
        foreach (array_chunk($barangays, 500) as $barangays_batch) {
            PSGCBarangay::insert($barangays_batch);
        }
    }
}
