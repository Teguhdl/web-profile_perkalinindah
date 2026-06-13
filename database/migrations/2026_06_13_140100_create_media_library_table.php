<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_library', function (Blueprint $table) {
            $table->id();
            $table->string('filename');           // nama file asli
            $table->string('path');               // storage/uploads/media/xxx.webp
            $table->string('mime')->nullable();   // image/webp, image/jpeg, application/pdf
            $table->unsignedBigInteger('size')->default(0); // bytes
            $table->string('alt')->nullable();    // alt text for SEO
            $table->string('title')->nullable(); // judul opsional
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->index('mime');
            $table->index('uploaded_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_library');
    }
};
