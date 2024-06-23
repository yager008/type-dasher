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
        Schema::create('saved_texts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('best_type_result_id')->default(0);
            $table->timestamps();
            $table->longText('text');
            $table->string('text_name');
            $table->integer('best_speed')->default(0);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('best_type_result_id')
                ->references('id')->on('type_results');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_texts');
    }
};
