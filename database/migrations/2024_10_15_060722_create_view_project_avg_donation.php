<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            create view v_projects_avg_donation as
            (select max(projects.id) as id, max(projects.title) as title, coalesce(avg(p.donation_amount), 0) as moyenne
            from projects
                     left join donations d on projects.id = d.project_id
                     left join v_valid_payments p on d.id = p.donation_id
            group by projects.id
            )"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop view IF EXISTS v_projects_avg_donation");
    }
};
