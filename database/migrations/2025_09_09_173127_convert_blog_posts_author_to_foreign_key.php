<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\BlogPost;

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
     * 
     * This migration converts the blog posts author from a varchar field
     * to a proper foreign key relationship with the users table.
     * This follows database normalization best practices.
     */
    public function up(): void
    {
        // Step 1: Add the new author_id column (nullable initially)
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->nullable()->after('category_id');
        });

        // Step 2: Create or get default author user
        $defaultAuthor = $this->getOrCreateDefaultAuthor();

        // Step 3: Migrate existing author data
        $this->migrateExistingAuthors($defaultAuthor);

        // Step 4: Make author_id non-nullable and add foreign key constraint
        Schema::table('blog_posts', function (Blueprint $table) use ($defaultAuthor) {
            // Update any remaining null values to default author
            DB::table('blog_posts')
                ->whereNull('author_id')
                ->update(['author_id' => $defaultAuthor->id]);

            // Make column non-nullable
            $table->unsignedBigInteger('author_id')->nullable(false)->change();
            
            // Add foreign key constraint
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict'); // Prevent deletion of users with blog posts
            
            // Add index for performance (only if not already created by performance indexes migration)
            if (!$this->indexExists('blog_posts', 'blog_posts_author_id_index')) {
                $table->index('author_id', 'blog_posts_author_id_index');
            }
        });

        // Step 5: Optionally keep the old author column for reference
        // You can drop it later after verifying the migration
        Schema::table('blog_posts', function (Blueprint $table) {
            // Rename old column for backup
            $table->renameColumn('author', 'author_legacy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key and index
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropIndex('blog_posts_author_id_index');
        });

        // Restore original author column
        Schema::table('blog_posts', function (Blueprint $table) {
            // Rename legacy column back
            if (Schema::hasColumn('blog_posts', 'author_legacy')) {
                $table->renameColumn('author_legacy', 'author');
            } else {
                // Recreate author column if legacy doesn't exist
                $table->string('author', 255)->default('Hexagon Team')->after('category_id');
                
                // Restore author names from users table
                $posts = BlogPost::with('author')->get();
                foreach ($posts as $post) {
                    if ($post->author) {
                        DB::table('blog_posts')
                            ->where('id', $post->id)
                            ->update(['author' => $post->author->name]);
                    }
                }
            }
            
            // Drop author_id column
            $table->dropColumn('author_id');
        });
    }

    /**
     * Get or create a default author user
     */
    private function getOrCreateDefaultAuthor(): User
    {
        // First, try to find an admin user
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            return $admin;
        }

        // If no admin exists, find or create a default author
        return User::firstOrCreate(
            ['email' => 'author@hexagonservicesolutions.com'],
            [
                'name' => 'Hexagon Team',
                'password' => bcrypt(Str::random(32)), // Random secure password
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );
    }

    /**
     * Migrate existing author names to user relationships
     */
    private function migrateExistingAuthors(User $defaultAuthor): void
    {
        // Get unique author names from existing posts
        $authorNames = DB::table('blog_posts')
            ->select('author')
            ->distinct()
            ->whereNotNull('author')
            ->pluck('author');

        $authorMapping = [];

        foreach ($authorNames as $authorName) {
            // Skip empty author names
            if (empty(trim($authorName))) {
                continue;
            }

            // Try to find existing user by name
            $user = User::where('name', $authorName)->first();

            if (!$user) {
                // Check if it's a variation of "Hexagon Team"
                if (stripos($authorName, 'hexagon') !== false || 
                    stripos($authorName, 'team') !== false ||
                    $authorName === 'Admin') {
                    $user = $defaultAuthor;
                } else {
                    // Create a new user for this author
                    $emailBase = Str::slug($authorName);
                    $email = $emailBase . '@hexagonservicesolutions.com';
                    
                    // Ensure unique email
                    $counter = 1;
                    while (User::where('email', $email)->exists()) {
                        $email = $emailBase . $counter . '@hexagonservicesolutions.com';
                        $counter++;
                    }

                    $user = User::create([
                        'name' => $authorName,
                        'email' => $email,
                        'password' => bcrypt(Str::random(32)),
                        'is_admin' => false,
                        'email_verified_at' => now(),
                    ]);

                    // Assign author role if RBAC is set up
                    if (class_exists('App\Models\Role')) {
                        $authorRole = DB::table('roles')->where('slug', 'author')->first();
                        if (!$authorRole) {
                            // Create author role if it doesn't exist
                            $authorRoleId = DB::table('roles')->insertGetId([
                                'name' => 'Author',
                                'slug' => 'author',
                                'description' => 'Blog post author',
                                'level' => 25,
                                'is_default' => false,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            // Grant blog permissions to author role
                            $blogPermissions = DB::table('permissions')
                                ->where('group', 'blog')
                                ->whereIn('slug', ['blog.view', 'blog.create', 'blog.edit'])
                                ->pluck('id');

                            foreach ($blogPermissions as $permissionId) {
                                DB::table('permission_role')->insert([
                                    'permission_id' => $permissionId,
                                    'role_id' => $authorRoleId,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        } else {
                            $authorRoleId = $authorRole->id;
                        }

                        // Assign role to user
                        DB::table('role_user')->insert([
                            'user_id' => $user->id,
                            'role_id' => $authorRoleId,
                            'assigned_at' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            $authorMapping[$authorName] = $user->id;
        }

        // Update all blog posts with the new author_id
        foreach ($authorMapping as $authorName => $userId) {
            DB::table('blog_posts')
                ->where('author', $authorName)
                ->update(['author_id' => $userId]);
        }

        // Handle posts with null or empty authors
        DB::table('blog_posts')
            ->where(function ($query) {
                $query->whereNull('author')
                    ->orWhere('author', '');
            })
            ->update(['author_id' => $defaultAuthor->id]);
    }
};
