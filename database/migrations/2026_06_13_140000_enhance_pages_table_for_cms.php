<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'content')) {
                $table->longText('content')->nullable()->after('view_name');
            }
            if (!Schema::hasColumn('pages', 'type')) {
                // 'system' = view fixed (dashboard/produk/portofolio/dll) | 'custom' = user-created via rich editor
                $table->string('type')->default('system')->after('view_name');
            }
            if (!Schema::hasColumn('pages', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('type');
            }
            if (!Schema::hasColumn('pages', 'show_in_menu')) {
                $table->boolean('show_in_menu')->default(true)->after('is_published');
            }
            if (!Schema::hasColumn('pages', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('show_in_menu');
            }
            if (!Schema::hasColumn('pages', 'og_image')) {
                $table->string('og_image')->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('pages', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('og_image');
            }
            if (!Schema::hasColumn('pages', 'hero_subtitle')) {
                $table->string('hero_subtitle')->nullable()->after('hero_image');
            }
        });

        // Mark existing system pages as 'system' type
        DB::table('pages')->update(['type' => 'system', 'is_published' => true, 'show_in_menu' => true]);
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            foreach (['content', 'type', 'is_published', 'show_in_menu', 'sort_order', 'og_image', 'hero_image', 'hero_subtitle'] as $col) {
                if (Schema::hasColumn('pages', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
