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
            create view v_projects_donation_count as (
                select d.project_id as id, count(d.project_id) as count from v_valid_payments p
                join donations d on p.donation_id = d.id
                where d.project_id is not null
                group by d.project_id
                order by d.project_id asc
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop view IF EXISTS v_projects_donation_count");
    }
};
