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
        DB::unprepared('
        CREATE TRIGGER id_store_room BEFORE INSERT ON rooms FOR EACH ROW
            BEGIN
                INSERT INTO room_sequences VALUES (NULL);
                SET NEW.bkg_room_id = CONCAT("BKG-", LPAD(LAST_INSERT_ID(), 8, "0"));
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER "id_store_room"');
    }
};
