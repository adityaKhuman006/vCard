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
        Schema::create('dynamic_vcards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vcard_id');
            $table->string('primary_color');
            $table->string('back_color');
            $table->string('back_seconds_color');
            $table->string('button_text_color');
            $table->string('text_label_color');
            $table->string('text_description_color');
            $table->timestamps();
            $table->foreign('vcard_id')->references('id')->on('vcards')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_vcards');
    }
};
