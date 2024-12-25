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
        Schema::create('event_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('event_id')->constrained()->cascadeOnDelete();

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();

            $table->unique(['event_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_schedules');
    }
};