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
        DB::statement("create view v_donation_breakdown as
            (
                SELECT 'direct'                                                              AS type,
                       SUM(CASE WHEN d.project_id IS NULL THEN p.donation_amount ELSE 0 END) AS donation
                FROM payments p
                         JOIN donations d ON p.donation_id = d.id
                WHERE p.status = 1
                UNION ALL
                SELECT 'projet'                                                                 AS type,
                       SUM(CASE WHEN d.project_id IS NOT NULL THEN p.donation_amount ELSE 0 END) AS donation
                FROM payments p
                         JOIN donations d ON p.donation_id = d.id
                WHERE p.status = 1
            )"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_donation_breakdown');
    }
};
