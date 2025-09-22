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
        // 1. Fix services table columns
        Schema::table('services', function (Blueprint $table) {
            // Rename columns to match expected names
            $table->renameColumn('title', 'name');
            $table->renameColumn('sort_order', 'order_index');
            
            // Add missing columns
            if (!Schema::hasColumn('services', 'features')) {
                $table->json('features')->nullable()->after('description');
            }
            if (!Schema::hasColumn('services', 'icon')) {
                $table->string('icon')->nullable()->after('features');
            }
            
            // Remove extra column that's not needed
            if (Schema::hasColumn('services', 'short_description')) {
                $table->dropColumn('short_description');
            }
            if (Schema::hasColumn('services', 'include_in_sitemap')) {
                $table->dropColumn('include_in_sitemap');
            }
        });

        // 2. Fix blog_posts table columns
        Schema::table('blog_posts', function (Blueprint $table) {
            // Rename columns to match expected names
            if (Schema::hasColumn('blog_posts', 'featured_image')) {
                $table->renameColumn('featured_image', 'thumbnail_url');
            }
            
            // Add missing columns
            if (!Schema::hasColumn('blog_posts', 'views')) {
                $table->integer('views')->default(0)->after('published_at');
            }
            
            // Remove extra columns
            if (Schema::hasColumn('blog_posts', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
            if (Schema::hasColumn('blog_posts', 'include_in_sitemap')) {
                $table->dropColumn('include_in_sitemap');
            }
        });

        // 3. Fix contact_submissions table columns
        Schema::table('contact_submissions', function (Blueprint $table) {
            // Rename columns to match expected names
            if (Schema::hasColumn('contact_submissions', 'service_requested')) {
                $table->renameColumn('service_requested', 'service');
            }
            
            // Remove extra columns that aren't in the expected schema
            if (Schema::hasColumn('contact_submissions', 'name')) {
                // Migrate name data to first_name and last_name if they exist
                DB::statement("UPDATE contact_submissions SET first_name = SUBSTRING_INDEX(name, ' ', 1), last_name = SUBSTRING_INDEX(name, ' ', -1) WHERE name IS NOT NULL");
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('contact_submissions', 'subject')) {
                $table->dropColumn('subject');
            }
            if (Schema::hasColumn('contact_submissions', 'ip_address')) {
                $table->dropColumn('ip_address');
            }
            if (Schema::hasColumn('contact_submissions', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
        });

        // 4. Fix landing_pages table columns
        Schema::table('landing_pages', function (Blueprint $table) {
            // Rename columns to match expected names
            if (Schema::hasColumn('landing_pages', 'title')) {
                $table->renameColumn('title', 'name');
            }
            
            // Add missing columns
            if (!Schema::hasColumn('landing_pages', 'headline')) {
                $table->string('headline')->nullable()->after('name');
            }
            if (!Schema::hasColumn('landing_pages', 'subheadline')) {
                $table->string('subheadline')->nullable()->after('headline');
            }
            if (!Schema::hasColumn('landing_pages', 'cta_text')) {
                $table->string('cta_text')->nullable()->after('content');
            }
            if (!Schema::hasColumn('landing_pages', 'cta_url')) {
                $table->string('cta_url')->nullable()->after('cta_text');
            }
            if (!Schema::hasColumn('landing_pages', 'features')) {
                $table->json('features')->nullable()->after('cta_url');
            }
            if (!Schema::hasColumn('landing_pages', 'testimonials')) {
                $table->json('testimonials')->nullable()->after('features');
            }
            
            // Remove extra columns
            if (Schema::hasColumn('landing_pages', 'include_in_sitemap')) {
                $table->dropColumn('include_in_sitemap');
            }
            if (Schema::hasColumn('landing_pages', 'conversion_tracking_code')) {
                $table->dropColumn('conversion_tracking_code');
            }
        });

        // 5. Fix tracking_scripts table columns
        Schema::table('tracking_scripts', function (Blueprint $table) {
            // Rename columns to match expected names
            if (Schema::hasColumn('tracking_scripts', 'script_code')) {
                $table->renameColumn('script_code', 'script_content');
            }
            if (Schema::hasColumn('tracking_scripts', 'position')) {
                $table->renameColumn('position', 'location');
            }
            
            // Remove extra columns
            if (Schema::hasColumn('tracking_scripts', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('tracking_scripts', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('tracking_scripts', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });

        // 6. Fix core_pages table - remove extra column
        Schema::table('core_pages', function (Blueprint $table) {
            if (Schema::hasColumn('core_pages', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        // 7. Fix failed_login_attempts table
        Schema::table('failed_login_attempts', function (Blueprint $table) {
            // Rename column to match expected name
            if (Schema::hasColumn('failed_login_attempts', 'last_attempt_at')) {
                $table->renameColumn('last_attempt_at', 'attempted_at');
            }
            
            // Remove extra columns
            if (Schema::hasColumn('failed_login_attempts', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
            if (Schema::hasColumn('failed_login_attempts', 'attempts')) {
                $table->dropColumn('attempts');
            }
            if (Schema::hasColumn('failed_login_attempts', 'locked_until')) {
                $table->dropColumn('locked_until');
            }
            if (Schema::hasColumn('failed_login_attempts', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('failed_login_attempts', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });

        // 8. Fix invitation_tokens table - remove extra columns
        Schema::table('invitation_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('invitation_tokens', 'invited_by')) {
                $table->dropColumn('invited_by');
            }
            if (Schema::hasColumn('invitation_tokens', 'used')) {
                $table->dropColumn('used');
            }
            if (Schema::hasColumn('invitation_tokens', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse services table changes
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->renameColumn('order_index', 'sort_order');
            $table->string('short_description')->nullable();
            $table->boolean('include_in_sitemap')->default(true);
            
            if (Schema::hasColumn('services', 'features')) {
                $table->dropColumn('features');
            }
            if (Schema::hasColumn('services', 'icon')) {
                $table->dropColumn('icon');
            }
        });

        // Reverse blog_posts table changes
        Schema::table('blog_posts', function (Blueprint $table) {
            if (Schema::hasColumn('blog_posts', 'thumbnail_url')) {
                $table->renameColumn('thumbnail_url', 'featured_image');
            }
            $table->string('thumbnail')->nullable();
            $table->boolean('include_in_sitemap')->default(true);
            
            if (Schema::hasColumn('blog_posts', 'views')) {
                $table->dropColumn('views');
            }
        });

        // Reverse contact_submissions table changes
        Schema::table('contact_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('contact_submissions', 'service')) {
                $table->renameColumn('service', 'service_requested');
            }
            $table->string('name')->nullable();
            $table->string('subject')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
        });

        // Reverse landing_pages table changes
        Schema::table('landing_pages', function (Blueprint $table) {
            if (Schema::hasColumn('landing_pages', 'name')) {
                $table->renameColumn('name', 'title');
            }
            $table->boolean('include_in_sitemap')->default(true);
            $table->text('conversion_tracking_code')->nullable();
            
            $columnsToRemove = ['headline', 'subheadline', 'cta_text', 'cta_url', 'features', 'testimonials'];
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('landing_pages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // Reverse tracking_scripts table changes
        Schema::table('tracking_scripts', function (Blueprint $table) {
            if (Schema::hasColumn('tracking_scripts', 'script_content')) {
                $table->renameColumn('script_content', 'script_code');
            }
            if (Schema::hasColumn('tracking_scripts', 'location')) {
                $table->renameColumn('location', 'position');
            }
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
        });

        // Reverse core_pages table changes
        Schema::table('core_pages', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });

        // Reverse failed_login_attempts table changes
        Schema::table('failed_login_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('failed_login_attempts', 'attempted_at')) {
                $table->renameColumn('attempted_at', 'last_attempt_at');
            }
            $table->string('user_agent')->nullable();
            $table->integer('attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
        });

        // Reverse invitation_tokens table changes
        Schema::table('invitation_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('invited_by')->nullable();
            $table->boolean('used')->default(false);
            $table->text('notes')->nullable();
        });
    }
};