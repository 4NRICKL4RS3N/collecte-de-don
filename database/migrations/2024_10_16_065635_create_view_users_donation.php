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
            create view v_users_donation as (
            select max(u.id) as id, max(u.name) as name, coalesce(sum(p.donation_amount), 0) as total
            from v_valid_payments p
                     left join donations d on p.donation_id = d.id
                     right join v_users_client u on d.user_id = u.id
            group by u.id
            order by total desc
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop view if exists v_users_donation");
    }
};
