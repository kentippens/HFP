<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Helper function to check if index exists
     */
    private function indexExists($table, $indexName): bool
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return count($indexes) > 0;
        }
        return false;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Blog Posts - Add missing indexes for common queries
        if (Schema::hasTable('blog_posts')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                if (Schema::hasColumn('blog_posts', 'category_id') && !$this->indexExists('blog_posts', 'blog_posts_category_id_index')) {
                    $table->index('category_id', 'blog_posts_category_id_index');
                }
                // Only create author_id index if the column exists (it may be added in a later migration)
                if (Schema::hasColumn('blog_posts', 'author_id') && !$this->indexExists('blog_posts', 'blog_posts_author_id_index')) {
                    $table->index('author_id', 'blog_posts_author_id_index');
                }
                if (Schema::hasColumn('blog_posts', 'is_published') && !$this->indexExists('blog_posts', 'blog_posts_is_published_index')) {
                    $table->index('is_published', 'blog_posts_is_published_index');
                }
                if (Schema::hasColumn('blog_posts', 'published_at') && !$this->indexExists('blog_posts', 'blog_posts_published_at_index')) {
                    $table->index('published_at', 'blog_posts_published_at_index');
                }
                if (Schema::hasColumn('blog_posts', 'slug') && !$this->indexExists('blog_posts', 'blog_posts_slug_index')) {
                    $table->index('slug', 'blog_posts_slug_index');
                }
                if (Schema::hasColumn('blog_posts', 'is_published') && Schema::hasColumn('blog_posts', 'published_at') && 
                    !$this->indexExists('blog_posts', 'blog_posts_published_date_idx')) {
                    $table->index(['is_published', 'published_at'], 'blog_posts_published_date_idx');
                }
                if (Schema::hasColumn('blog_posts', 'category_id') && Schema::hasColumn('blog_posts', 'is_published') && 
                    Schema::hasColumn('blog_posts', 'published_at') && !$this->indexExists('blog_posts', 'blog_posts_cat_published_idx')) {
                    $table->index(['category_id', 'is_published', 'published_at'], 'blog_posts_cat_published_idx');
                }
            });
        }

        // Blog Categories - Add indexes
        if (Schema::hasTable('blog_categories')) {
            Schema::table('blog_categories', function (Blueprint $table) {
                if (Schema::hasColumn('blog_categories', 'slug') && !$this->indexExists('blog_categories', 'blog_categories_slug_index')) {
                    $table->index('slug', 'blog_categories_slug_index');
                }
                if (Schema::hasColumn('blog_categories', 'is_active') && !$this->indexExists('blog_categories', 'blog_categories_is_active_index')) {
                    $table->index('is_active', 'blog_categories_is_active_index');
                }
                if (Schema::hasColumn('blog_categories', 'sort_order') && !$this->indexExists('blog_categories', 'blog_categories_sort_order_index')) {
                    $table->index('sort_order', 'blog_categories_sort_order_index');
                }
                if (Schema::hasColumn('blog_categories', 'is_active') && Schema::hasColumn('blog_categories', 'sort_order') && 
                    !$this->indexExists('blog_categories', 'blog_categories_active_order_idx')) {
                    $table->index(['is_active', 'sort_order'], 'blog_categories_active_order_idx');
                }
            });
        }

        // Contact Submissions - Add indexes
        if (Schema::hasTable('contact_submissions')) {
            Schema::table('contact_submissions', function (Blueprint $table) {
                if (Schema::hasColumn('contact_submissions', 'email') && !$this->indexExists('contact_submissions', 'contact_submissions_email_index')) {
                    $table->index('email', 'contact_submissions_email_index');
                }
                if (Schema::hasColumn('contact_submissions', 'phone') && !$this->indexExists('contact_submissions', 'contact_submissions_phone_index')) {
                    $table->index('phone', 'contact_submissions_phone_index');
                }
                if (Schema::hasColumn('contact_submissions', 'service') && !$this->indexExists('contact_submissions', 'contact_submissions_service_index')) {
                    $table->index('service', 'contact_submissions_service_index');
                }
                if (Schema::hasColumn('contact_submissions', 'status') && !$this->indexExists('contact_submissions', 'contact_submissions_status_index')) {
                    $table->index('status', 'contact_submissions_status_index');
                }
                if (Schema::hasColumn('contact_submissions', 'created_at') && !$this->indexExists('contact_submissions', 'contact_submissions_created_at_index')) {
                    $table->index('created_at', 'contact_submissions_created_at_index');
                }
                if (Schema::hasColumn('contact_submissions', 'status') && Schema::hasColumn('contact_submissions', 'created_at') && 
                    !$this->indexExists('contact_submissions', 'contact_submissions_status_date_idx')) {
                    $table->index(['status', 'created_at'], 'contact_submissions_status_date_idx');
                }
            });
        }

        // Core Pages - Add indexes
        if (Schema::hasTable('core_pages')) {
            Schema::table('core_pages', function (Blueprint $table) {
                if (Schema::hasColumn('core_pages', 'slug') && !$this->indexExists('core_pages', 'core_pages_slug_index')) {
                    $table->index('slug', 'core_pages_slug_index');
                }
                if (Schema::hasColumn('core_pages', 'is_active') && !$this->indexExists('core_pages', 'core_pages_is_active_index')) {
                    $table->index('is_active', 'core_pages_is_active_index');
                }
                if (Schema::hasColumn('core_pages', 'template') && !$this->indexExists('core_pages', 'core_pages_template_index')) {
                    $table->index('template', 'core_pages_template_index');
                }
                if (Schema::hasColumn('core_pages', 'is_active') && Schema::hasColumn('core_pages', 'slug') && 
                    !$this->indexExists('core_pages', 'core_pages_active_slug_idx')) {
                    $table->index(['is_active', 'slug'], 'core_pages_active_slug_idx');
                }
            });
        }

        // Landing Pages - Add indexes
        if (Schema::hasTable('landing_pages')) {
            Schema::table('landing_pages', function (Blueprint $table) {
                if (Schema::hasColumn('landing_pages', 'slug') && !$this->indexExists('landing_pages', 'landing_pages_slug_index')) {
                    $table->index('slug', 'landing_pages_slug_index');
                }
                if (Schema::hasColumn('landing_pages', 'is_active') && !$this->indexExists('landing_pages', 'landing_pages_is_active_index')) {
                    $table->index('is_active', 'landing_pages_is_active_index');
                }
                if (Schema::hasColumn('landing_pages', 'service_id') && !$this->indexExists('landing_pages', 'landing_pages_service_id_index')) {
                    $table->index('service_id', 'landing_pages_service_id_index');
                }
                if (Schema::hasColumn('landing_pages', 'template') && !$this->indexExists('landing_pages', 'landing_pages_template_index')) {
                    $table->index('template', 'landing_pages_template_index');
                }
                if (Schema::hasColumn('landing_pages', 'is_active') && Schema::hasColumn('landing_pages', 'slug') && 
                    !$this->indexExists('landing_pages', 'landing_pages_active_slug_idx')) {
                    $table->index(['is_active', 'slug'], 'landing_pages_active_slug_idx');
                }
            });
        }

        // Services - Add additional indexes
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                if (Schema::hasColumn('services', 'parent_id') && Schema::hasColumn('services', 'is_active') && 
                    Schema::hasColumn('services', 'order_index') && !$this->indexExists('services', 'services_hierarchy_idx')) {
                    $table->index(['parent_id', 'is_active', 'order_index'], 'services_hierarchy_idx');
                }
                if (Schema::hasColumn('services', 'include_in_sitemap') && Schema::hasColumn('services', 'is_active') && 
                    !$this->indexExists('services', 'services_sitemap_idx')) {
                    $table->index(['include_in_sitemap', 'is_active'], 'services_sitemap_idx');
                }
            });
        }

        // Failed Login Attempts - Add indexes
        if (Schema::hasTable('failed_login_attempts')) {
            Schema::table('failed_login_attempts', function (Blueprint $table) {
                if (Schema::hasColumn('failed_login_attempts', 'email') && !$this->indexExists('failed_login_attempts', 'failed_login_attempts_email_index')) {
                    $table->index('email', 'failed_login_attempts_email_index');
                }
                if (Schema::hasColumn('failed_login_attempts', 'ip_address') && !$this->indexExists('failed_login_attempts', 'failed_login_attempts_ip_index')) {
                    $table->index('ip_address', 'failed_login_attempts_ip_index');
                }
                if (Schema::hasColumn('failed_login_attempts', 'created_at') && !$this->indexExists('failed_login_attempts', 'failed_login_attempts_created_at_index')) {
                    $table->index('created_at', 'failed_login_attempts_created_at_index');
                }
                if (Schema::hasColumn('failed_login_attempts', 'email') && Schema::hasColumn('failed_login_attempts', 'created_at') && 
                    !$this->indexExists('failed_login_attempts', 'failed_login_attempts_email_time_idx')) {
                    $table->index(['email', 'created_at'], 'failed_login_attempts_email_time_idx');
                }
                if (Schema::hasColumn('failed_login_attempts', 'ip_address') && Schema::hasColumn('failed_login_attempts', 'created_at') && 
                    !$this->indexExists('failed_login_attempts', 'failed_login_attempts_ip_time_idx')) {
                    $table->index(['ip_address', 'created_at'], 'failed_login_attempts_ip_time_idx');
                }
            });
        }

        // Password Histories - Add indexes
        if (Schema::hasTable('password_histories')) {
            Schema::table('password_histories', function (Blueprint $table) {
                if (Schema::hasColumn('password_histories', 'user_id') && !$this->indexExists('password_histories', 'password_histories_user_id_index')) {
                    $table->index('user_id', 'password_histories_user_id_index');
                }
                if (Schema::hasColumn('password_histories', 'user_id') && Schema::hasColumn('password_histories', 'created_at') && 
                    !$this->indexExists('password_histories', 'password_histories_user_created_idx')) {
                    $table->index(['user_id', 'created_at'], 'password_histories_user_created_idx');
                }
            });
        }

        // Invitation Tokens - Add indexes
        if (Schema::hasTable('invitation_tokens')) {
            Schema::table('invitation_tokens', function (Blueprint $table) {
                if (Schema::hasColumn('invitation_tokens', 'token') && !$this->indexExists('invitation_tokens', 'invitation_tokens_token_index')) {
                    $table->index('token', 'invitation_tokens_token_index');
                }
                if (Schema::hasColumn('invitation_tokens', 'email') && !$this->indexExists('invitation_tokens', 'invitation_tokens_email_index')) {
                    $table->index('email', 'invitation_tokens_email_index');
                }
                if (Schema::hasColumn('invitation_tokens', 'expires_at') && !$this->indexExists('invitation_tokens', 'invitation_tokens_expires_at_index')) {
                    $table->index('expires_at', 'invitation_tokens_expires_at_index');
                }
                if (Schema::hasColumn('invitation_tokens', 'used') && !$this->indexExists('invitation_tokens', 'invitation_tokens_used_index')) {
                    $table->index('used', 'invitation_tokens_used_index');
                }
                if (Schema::hasColumn('invitation_tokens', 'token') && Schema::hasColumn('invitation_tokens', 'used') && 
                    Schema::hasColumn('invitation_tokens', 'expires_at') && !$this->indexExists('invitation_tokens', 'invitation_tokens_valid_idx')) {
                    $table->index(['token', 'used', 'expires_at'], 'invitation_tokens_valid_idx');
                }
            });
        }

        // Sessions - Add indexes
        if (Schema::hasTable('sessions')) {
            Schema::table('sessions', function (Blueprint $table) {
                if (Schema::hasColumn('sessions', 'user_id') && !$this->indexExists('sessions', 'sessions_user_id_index')) {
                    $table->index('user_id', 'sessions_user_id_index');
                }
                if (Schema::hasColumn('sessions', 'last_activity') && !$this->indexExists('sessions', 'sessions_last_activity_index')) {
                    $table->index('last_activity', 'sessions_last_activity_index');
                }
            });
        }

        // Roles - Add indexes
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                if (Schema::hasColumn('roles', 'is_default') && !$this->indexExists('roles', 'roles_is_default_index')) {
                    $table->index('is_default', 'roles_is_default_index');
                }
            });
        }

        // Add Full-text indexes for search functionality (MySQL specific)
        if (DB::connection()->getDriverName() === 'mysql') {
            try {
                // Check and add full-text indexes
                if (Schema::hasTable('blog_posts') && !$this->indexExists('blog_posts', 'fulltext_blog_search')) {
                    DB::statement('ALTER TABLE blog_posts ADD FULLTEXT fulltext_blog_search(title, excerpt, content)');
                }
                
                if (Schema::hasTable('services') && !$this->indexExists('services', 'fulltext_service_search')) {
                    DB::statement('ALTER TABLE services ADD FULLTEXT fulltext_service_search(name, short_description, description)');
                }
                
                if (Schema::hasTable('core_pages') && !$this->indexExists('core_pages', 'fulltext_page_search')) {
                    DB::statement('ALTER TABLE core_pages ADD FULLTEXT fulltext_page_search(title, content)');
                }
            } catch (\Exception $e) {
                // Log error but don't fail migration
                \Log::warning('Could not create full-text indexes: ' . $e->getMessage());
            }
        }

        // Optimize tables for better performance
        if (DB::connection()->getDriverName() === 'mysql') {
            $tables = [
                'users', 'services', 'blog_posts', 'blog_categories',
                'contact_submissions', 'core_pages', 'landing_pages',
                'roles', 'permissions', 'role_user', 'permission_role',
                'permission_user', 'failed_login_attempts', 'password_histories'
            ];
            
            foreach ($tables as $table) {
                if (Schema::hasTable($table)) {
                    try {
                        DB::statement("ANALYZE TABLE {$table}");
                    } catch (\Exception $e) {
                        // Continue even if analyze fails
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop Full-text indexes if they exist
        if (DB::connection()->getDriverName() === 'mysql') {
            try {
                if ($this->indexExists('blog_posts', 'fulltext_blog_search')) {
                    DB::statement('ALTER TABLE blog_posts DROP INDEX fulltext_blog_search');
                }
                if ($this->indexExists('services', 'fulltext_service_search')) {
                    DB::statement('ALTER TABLE services DROP INDEX fulltext_service_search');
                }
                if ($this->indexExists('core_pages', 'fulltext_page_search')) {
                    DB::statement('ALTER TABLE core_pages DROP INDEX fulltext_page_search');
                }
            } catch (\Exception $e) {}
        }

        // Drop indexes safely
        $indexesToDrop = [
            'blog_posts' => [
                'blog_posts_category_id_index',
                'blog_posts_author_id_index', // Will be skipped if doesn't exist
                'blog_posts_is_published_index',
                'blog_posts_published_at_index',
                'blog_posts_slug_index',
                'blog_posts_published_date_idx',
                'blog_posts_cat_published_idx'
            ],
            'blog_categories' => [
                'blog_categories_slug_index',
                'blog_categories_is_active_index',
                'blog_categories_sort_order_index',
                'blog_categories_active_order_idx'
            ],
            'contact_submissions' => [
                'contact_submissions_email_index',
                'contact_submissions_phone_index',
                'contact_submissions_service_index',
                'contact_submissions_status_index',
                'contact_submissions_created_at_index',
                'contact_submissions_status_date_idx'
            ],
            'core_pages' => [
                'core_pages_slug_index',
                'core_pages_is_active_index',
                'core_pages_template_index',
                'core_pages_active_slug_idx'
            ],
            'landing_pages' => [
                'landing_pages_slug_index',
                'landing_pages_is_active_index',
                'landing_pages_service_id_index',
                'landing_pages_template_index',
                'landing_pages_active_slug_idx'
            ],
            'services' => [
                'services_hierarchy_idx',
                'services_sitemap_idx'
            ],
            'failed_login_attempts' => [
                'failed_login_attempts_email_index',
                'failed_login_attempts_ip_index',
                'failed_login_attempts_created_at_index',
                'failed_login_attempts_email_time_idx',
                'failed_login_attempts_ip_time_idx'
            ],
            'password_histories' => [
                'password_histories_user_id_index',
                'password_histories_user_created_idx'
            ],
            'invitation_tokens' => [
                'invitation_tokens_token_index',
                'invitation_tokens_email_index',
                'invitation_tokens_expires_at_index',
                'invitation_tokens_used_index',
                'invitation_tokens_valid_idx'
            ],
            'sessions' => [
                'sessions_user_id_index',
                'sessions_last_activity_index'
            ],
            'roles' => [
                'roles_is_default_index'
            ]
        ];

        foreach ($indexesToDrop as $table => $indexes) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) use ($indexes) {
                    foreach ($indexes as $index) {
                        try {
                            $table->dropIndex($index);
                        } catch (\Exception $e) {
                            // Index might not exist, continue
                        }
                    }
                });
            }
        }
    }
};