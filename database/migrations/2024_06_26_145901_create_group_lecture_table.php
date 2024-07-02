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
        Schema::create('group_lecture', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('lecture_id');
            $table->unsignedInteger('order_number');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('lecture_id')
                ->references('id')
                ->on('lectures')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_lecture');
    }
};
