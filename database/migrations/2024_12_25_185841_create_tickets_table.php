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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('event_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            $table->string('type');

            $table->unsignedInteger('max_tickets_per_user')->default(1);
            $table->unsignedInteger('reservation_expiration_minutes')->default(15);

            $table->unsignedInteger('price');
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('sold')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
