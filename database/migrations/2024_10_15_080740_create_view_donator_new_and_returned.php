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
            create view v_donator_new_and_returned as
            (select 'new' as category, count(*) as donation_count
            from v_users_donation_count
            where v_users_donation_count.donation_count = 1
            union all
            select 'returned' as category, count(*) as donation_count
            from v_users_donation_count
            where v_users_donation_count.donation_count > 1)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop view if exists v_donator_new_and_returned");
    }
};
