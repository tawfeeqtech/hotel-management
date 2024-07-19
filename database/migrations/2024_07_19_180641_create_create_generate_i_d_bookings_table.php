<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('create_generate_i_d_bookings', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        DB::unprepared('
        CREATE TRIGGER id_store BEFORE INSERT ON bookings FOR EACH ROW
            BEGIN
                INSERT INTO sequence_tbls VALUES (NULL);
                SET NEW.bkg_id = CONCAT("BKG-",LPAD(LAST_INSERT_ID(),8,"0"));
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('create_generate_i_d_bookings');
        DB::unprepared('DROP TRIGGER "id_store"');
    }
};
