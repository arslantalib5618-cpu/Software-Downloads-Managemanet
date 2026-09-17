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
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->foreignId('subcategory_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('downloads_count');
            $table->string('rating');
            $table->string('download_button_text')->default('Download Now');
            $table->string('download_url');
            $table->string('official_button_text')->default('Official Website');
            $table->string('official_website')->nullable();
            $table->json('screenshots')->nullable();
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
