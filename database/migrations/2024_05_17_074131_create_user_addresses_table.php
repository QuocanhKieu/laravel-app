<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address_detail');
            $table->string('province_code', 20)->nullable()->collation('utf8_vietnamese_ci'); // Adjusted collation
            $table->string('district_code')->nullable()->collation('utf8_vietnamese_ci');
            $table->string('ward_code')->nullable()->collation('utf8_vietnamese_ci');
            $table->unsignedSmallInteger('status')->default(0); // Adjust data type as needed (e.g., enum, integer)
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('province_code')->references('code')->on('provinces')->onDelete('set null');
            $table->foreign('district_code')->references('code')->on('districts')->onDelete('set null');
            $table->foreign('ward_code')->references('code')->on('wards')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
