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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->unsignedInteger('developer');
            $table->longText('task_link')->nullable();
            $table->longText('pr_link')->nullable();
            $table->unsignedInteger('approver');
            $table->smallInteger('local_impact')->nullable();
            $table->smallInteger('global_impact')->nullable();
            $table->unsignedInteger('project_id');
            $table->smallInteger('development_status');
            $table->smallInteger('release_status');
            $table->smallInteger('live_status');
            $table->unsignedInteger('tested_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
