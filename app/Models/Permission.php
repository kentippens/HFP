<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'group',
        'description'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            if (empty($permission->slug)) {
                $permission->slug = Str::slug($permission->name);
            }
        });
    }

    /**
     * Get roles that have this permission
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role')
            ->withTimestamps();
    }

    /**
     * Get users that have this permission directly
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'permission_user')
            ->withPivot(['assigned_at', 'expires_at'])
            ->withTimestamps();
    }

    /**
     * Get all permissions grouped by their group
     */
    public static function getGrouped()
    {
        return static::orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy('group');
    }

    /**
     * Create multiple permissions at once
     */
    public static function createMany(array $permissions)
    {
        $created = [];
        
        foreach ($permissions as $permission) {
            if (is_string($permission)) {
                $permission = ['name' => $permission];
            }
            
            $permission['slug'] = $permission['slug'] ?? Str::slug($permission['name']);
            
            $created[] = static::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
        
        return collect($created);
    }
}
