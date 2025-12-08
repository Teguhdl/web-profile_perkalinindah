<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string('label'); // Nama yang tampil di menu
            $table->string('slug')->nullable(); // URL /slug atau #
            $table->unsignedBigInteger('parent_id')->default(0); // Parent item (0 = menu utama)
            $table->string('view_name');

            // Meta SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Untuk hubungan recursive (optional, no foreign key)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
