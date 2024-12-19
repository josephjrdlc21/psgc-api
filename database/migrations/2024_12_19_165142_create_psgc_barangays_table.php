<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('psgc_barangays', function (Blueprint $table) {
            $table->id();
            $table->string('region_code')->nullable();
            $table->string('province_code')->nullable();
            $table->string('citymun_code')->nullable();
            $table->string('barangay_code')->nullable();
            $table->string('barangay_desc')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('barangay_status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psgc_barangays');
    }
};
