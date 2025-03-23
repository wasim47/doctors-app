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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->integer('hospital_id');
            $table->integer('branch_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('bmdc')->nullable();
            $table->string('designation')->nullable();
            $table->string('degree')->nullable();
            $table->integer('experience')->nullable();
            $table->string('about')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other', 'Not Declare']);
            $table->string('email')->unique();
            $table->string('phone_no')->unique();
            $table->float('regular_fee');
            $table->float('report_fee');
            $table->string('report_fee_applicable')->nullable();
            $table->tinyInteger('status')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
