<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_objectives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_project');
            $table->foreign('id_project')->references('id')->on('projects');
            $table->string('objective');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objectives_project');
    }
};
