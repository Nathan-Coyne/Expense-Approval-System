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
        Schema::create('models_has_statuses', function (Blueprint $table) {
            $table->id();

            // Status relationship
            $table->foreignId('status_id')
                ->constrained('statuses')
                ->cascadeOnDelete();

            // Polymorphic relationship
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');  // App\Models\Post, App\Models\User, etc

            // Indexes
            $table->index(['model_id', 'model_type']);

            // Prevent duplicate status assignments
            $table->unique(['status_id', 'model_id', 'model_type']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models_has_statuses');
    }
};
