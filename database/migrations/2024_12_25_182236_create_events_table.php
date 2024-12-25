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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();

            $table->string('slug')->unique();

            $table->string('name');
            $table->text('description')->nullable();

            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->string('venue')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
