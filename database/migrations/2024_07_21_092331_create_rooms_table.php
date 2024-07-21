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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('bkg_room_id');
            $table->string('name')->nullable();
            $table->string('room_type')->nullable();
            $table->string('ac_non_ac')->nullable();
            $table->string('food')->nullable();
            $table->string('bed_count')->nullable();
            $table->string('charges_for_cancellation')->nullable();
            $table->string('rent')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fileupload')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
