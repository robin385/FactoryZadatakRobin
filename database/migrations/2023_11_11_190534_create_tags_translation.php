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
       Schema::create('tags_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tags_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->timestamps();

            $table->unique(['tags_id','locale']);
            $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags_translation');
    }
};
