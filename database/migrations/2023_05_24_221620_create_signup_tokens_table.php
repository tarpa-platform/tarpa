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
        Schema::create('signup_tokens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->nullableUuidMorphs('registrant');
			$table->string('signup_role');
            $table->string('token', 14)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signup_tokens');
    }
};
