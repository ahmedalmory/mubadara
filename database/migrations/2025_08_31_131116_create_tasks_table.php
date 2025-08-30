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
            $table->foreignId('initiative_id')->constrained()->cascadeOnDelete();
            $table->json('title'); // Store both English and Arabic titles
            $table->json('description')->nullable(); // Store both English and Arabic descriptions
            $table->integer('points_value')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('order')->default(0); // For ordering tasks within an initiative
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
