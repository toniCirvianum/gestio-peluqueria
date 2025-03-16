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
        DB::unprepared(
            '
            CREATE TRIGGER tr_after_insert_reservation_service
            AFTER INSERT ON reservation_services
            FOR EACH ROW
            BEGIN
                DECLARE total_duration DECIMAL(4,2);

                SELECT SUM(s.duration * rs.quantity) INTO total_duration
                FROM reservation_services rs
                JOIN services s ON rs.service_id = s.id
                WHERE rs.reservation_id = NEW.reservation_id;

                UPDATE reservations
                SET estimated_duration = total_duration
                WHERE id = NEW.reservation_id;
            END;
            '
        );
        DB::unprepared('
            CREATE TRIGGER tr_after_delete_reservation_service
            AFTER DELETE ON reservation_services
            FOR EACH ROW
            BEGIN
                DECLARE total_duration DECIMAL(4,2);
                SELECT SUM(s.duration * rs.quantity) INTO total_duration
                FROM reservation_services rs
                JOIN services s ON rs.service_id = s.id
                WHERE rs.reservation_id = OLD.reservation_id;

                UPDATE reservations
                SET estimated_duration = total_duration
                WHERE id = OLD.reservation_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `tr_after_insert_reservation_service`');
        DB::unprepared('DROP TRIGGER `tr_after_delete_reservation_service`');
    }
};
