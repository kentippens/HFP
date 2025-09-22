<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'level',
        'is_default'
    ];

    protected $casts = [
        'level' => 'integer',
        'is_default' => 'boolean'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            if (empty($role->slug)) {
                $role->slug = Str::slug($role->name);
            }
        });
    }

    /**
     * Get users with this role
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withPivot(['assigned_at', 'expires_at'])
            ->withTimestamps();
    }

    /**
     * Get permissions assigned to this role
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
            ->withTimestamps();
    }

    /**
     * Check if role has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()
            ->where('slug', $permission)
            ->exists();
    }

    /**
     * Assign permission to role
     */
    public function givePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        }

        if (!$this->permissions->contains($permission->id)) {
            $this->permissions()->attach($permission->id);
        }

        return $this;
    }

    /**
     * Remove permission from role
     */
    public function revokePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->first();
        }

        if ($permission) {
            $this->permissions()->detach($permission->id);
        }

        return $this;
    }

    /**
     * Sync permissions for role
     */
    public function syncPermissions(array $permissions)
    {
        $permissionIds = collect($permissions)->map(function ($permission) {
            if (is_numeric($permission)) {
                return $permission;
            }
            if (is_string($permission)) {
                return Permission::where('slug', $permission)->first()?->id;
            }
            return $permission->id ?? null;
        })->filter()->toArray();

        $this->permissions()->sync($permissionIds);

        return $this;
    }

    /**
     * Check if this is a super admin role
     */
    public function isSuperAdmin(): bool
    {
        return $this->slug === 'super-admin' || $this->level >= 100;
    }

    /**
     * Check if this is an admin role
     */
    public function isAdmin(): bool
    {
        return in_array($this->slug, ['super-admin', 'admin']) || $this->level >= 50;
    }
}
