<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tagline');
            $table->string('category')->nullable();
            $table->string('role')->nullable();
            $table->string('client')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->text('summary');
            $table->longText('problem')->nullable();
            $table->longText('solution')->nullable();
            $table->longText('outcome')->nullable();
            $table->json('highlights')->nullable();
            $table->json('metrics')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('live_url')->nullable();
            $table->string('repo_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
