<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cocktails', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            // Use binary for BLOB, then convert to MEDIUMBLOB
            $table->binary('image_data')->nullable();
            $table->foreignId('type_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Alter the `image_data` column to MEDIUMBLOB for larger storage
        DB::statement('ALTER TABLE cocktails MODIFY image_data MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cocktails');
    }
};