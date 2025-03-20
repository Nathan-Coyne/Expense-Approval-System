<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('entity_entity_permissions', function (Blueprint $table) {
            $table->id();
            $table->morphs('granter');
            $table->morphs('grantee');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['granter_id', 'granter_type', 'grantee_id', 'grantee_type', 'permission_id'], 'unique_entity_permission');
        });
    }

    public function down()
    {
        Schema::dropIfExists('entity_entity_permissions');
    }
};
