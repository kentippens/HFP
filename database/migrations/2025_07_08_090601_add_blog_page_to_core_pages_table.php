<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CorePage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        CorePage::updateOrCreate(
            ['slug' => 'blog'],
            [
                'name' => 'Blog',
                'slug' => 'blog',
                'meta_title' => 'Blog - Latest News & Tips from Our Cleaning Experts',
                'meta_description' => 'Stay updated with the latest cleaning tips, industry news, and expert advice from our professional cleaning team.',
                'meta_keywords' => 'cleaning blog, cleaning tips, cleaning advice, professional cleaning, cleaning news, maintenance tips',
                'canonical_url' => url('/blog'),
                'is_active' => true,
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        CorePage::where('slug', 'blog')->delete();
    }
};
