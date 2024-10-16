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
        DB::statement("
            CREATE PROCEDURE p_donation_summary(IN num_days INT)
            BEGIN
                WITH RECURSIVE date_series AS (
                    SELECT CURDATE() - INTERVAL (num_days - 1) DAY AS payment_date
                    UNION ALL
                    SELECT payment_date + INTERVAL 1 DAY
                    FROM date_series
                    WHERE payment_date < CURDATE()
                )
                SELECT
                    ds.payment_date,
                    COALESCE(SUM(p.donation_amount), 0) AS total_donation
                FROM
                    date_series ds
                LEFT JOIN
                    collecte_don.payments p ON DATE(p.created_at) = ds.payment_date
                GROUP BY
                    ds.payment_date
                ORDER BY
                    ds.payment_date DESC;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP PROCEDURE IF EXISTS p_donation_summary;");
    }
};
