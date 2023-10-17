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
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('description')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->string('status');
            $table->dateTime('status_date')->nullable();
            $table->foreignUuid('assigned_to')->nullable();
			$table->foreignUuid('completed_by')->nullable();
			$table->foreignUuid('participant_id')->nullable();
            $table->foreignUuid('event_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
