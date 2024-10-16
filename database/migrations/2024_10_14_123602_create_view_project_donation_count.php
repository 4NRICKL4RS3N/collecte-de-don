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
                select projects.id, count(d.id) as count from projects
                left join donations d on projects.id = d.project_id
                left join v_valid_payments p on d.id = p.donation_id
                group by projects.id
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
