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
        Schema::create('listened_lectures', function (Blueprint $table) {
            $table->id();
            $table->morphs('listenable');
            $table->unsignedBigInteger('lecture_id');
            $table->timestamps();

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
        Schema::dropIfExists('listened_lectures');
    }
};
