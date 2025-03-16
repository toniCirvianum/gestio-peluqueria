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
        DB::unprepared("
             CREATE TRIGGER tr_before_insert_reservations
            BEFORE INSERT ON reservations
            FOR EACH ROW
            BEGIN
                DECLARE overlapping_reservations INT;

                -- Comprovar si ja hi ha una reserva amb el mateix worker_id i work_area a la mateixa data i hora exacta
                SELECT COUNT(*) INTO overlapping_reservations
                FROM reservations
                WHERE worker_id = NEW.worker_id
                  AND work_area = NEW.work_area
                  AND reservation_date = NEW.reservation_date;

                IF overlapping_reservations > 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Aquest treballador i àrea de treball ja tenen una reserva programada per aquesta data i hora.';
                END IF;

                -- Comprovar si hi ha una reserva que es solapa durant el estimated_duration per worker_id i work_area
                SELECT COUNT(*) INTO overlapping_reservations
                FROM reservations
                WHERE worker_id = NEW.worker_id
                  AND work_area = NEW.work_area
                  AND (
                        -- Comprovar si la nova reserva comença dins la franja d'una reserva existent
                        (NEW.reservation_date BETWEEN reservation_date AND DATE_ADD(reservation_date, INTERVAL (COALESCE(estimated_duration, 0) * 60) MINUTE))

                        -- Comprovar si la finalització de la nova reserva entra en la franja d'una reserva existent
                        OR
                        (DATE_ADD(NEW.reservation_date, INTERVAL (COALESCE(NEW.estimated_duration, 0) * 60) MINUTE)
                         BETWEEN reservation_date AND DATE_ADD(reservation_date, INTERVAL (COALESCE(estimated_duration, 0) * 60) MINUTE))

                        -- Comprovar si la nova reserva cobreix completament la franja d'una reserva existent
                        OR
                        (NEW.reservation_date <= reservation_date
                         AND DATE_ADD(NEW.reservation_date, INTERVAL (COALESCE(NEW.estimated_duration, 0) * 60) MINUTE)
                         >= DATE_ADD(reservation_date, INTERVAL (COALESCE(estimated_duration, 0) * 60) MINUTE))
                      );

                IF overlapping_reservations > 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Aquest treballador o àrea de treball ja tenen una altra reserva durant aquest període de temps.';
                END IF;
            END;

            CREATE TRIGGER before_update_reservations
            BEFORE UPDATE ON reservations
            FOR EACH ROW
            BEGIN
                DECLARE overlapping_reservations INT;

                -- Comprovar si ja hi ha una reserva amb el mateix worker_id i work_area a la mateixa data i hora exacta
                SELECT COUNT(*) INTO overlapping_reservations
                FROM reservations
                WHERE worker_id = NEW.worker_id
                  AND work_area = NEW.work_area
                  AND reservation_date = NEW.reservation_date
                  AND id != NEW.id;

                IF overlapping_reservations > 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Aquest treballador i àrea de treball ja tenen una reserva programada per aquesta data i hora.';
                END IF;

                -- Comprovar si hi ha una reserva que es solapa durant el estimated_duration per worker_id i work_area
                SELECT COUNT(*) INTO overlapping_reservations
                FROM reservations
                WHERE worker_id = NEW.worker_id
                  AND work_area = NEW.work_area
                  AND id != NEW.id
                  AND (
                        (NEW.reservation_date BETWEEN reservation_date AND DATE_ADD(reservation_date, INTERVAL (COALESCE(estimated_duration, 0) * 60) MINUTE))
                        OR
                        (DATE_ADD(NEW.reservation_date, INTERVAL (COALESCE(NEW.estimated_duration, 0) * 60) MINUTE)
                         BETWEEN reservation_date AND DATE_ADD(reservation_date, INTERVAL (COALESCE(estimated_duration, 0) * 60) MINUTE))
                        OR
                        (NEW.reservation_date <= reservation_date
                         AND DATE_ADD(NEW.reservation_date, INTERVAL (COALESCE(NEW.estimated_duration, 0) * 60) MINUTE)
                         >= DATE_ADD(reservation_date, INTERVAL (COALESCE(estimated_duration, 0) * 60) MINUTE))
                      );

                IF overlapping_reservations > 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Aquest treballador o àrea de treball ja tenen una altra reserva durant aquest període de temps.';
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER tr_before_insert_reservations');
        DB::unprepared('DROP TRIGGER tr_before_update_reservations');
    }
};
