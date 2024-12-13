<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_objectives', function (Blueprint $table) {
            $table->renameColumn('id_project', 'project_id');
        });
    }

    public function down(): void
    {
        Schema::table('project_objectives', function (Blueprint $table) {
            $table->renameColumn('project_id', 'id_project');
        });
    }
};
