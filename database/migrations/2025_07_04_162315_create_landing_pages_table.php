<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('conversion_tracking_code')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
};