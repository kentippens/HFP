<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserImportService extends BaseImportService
{
    protected function getModel(): string
    {
        return User::class;
    }

    public function getValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8',
            'roles' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'email_verified' => 'nullable|boolean',
        ];
    }

    protected function transformRow(array $row): array
    {
        // Generate name from first_name and last_name if not provided
        if (empty($row['name'])) {
            $row['name'] = trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
        }

        // Split name into first_name and last_name if they're not provided
        if (empty($row['first_name']) || empty($row['last_name'])) {
            $nameParts = explode(' ', $row['name'], 2);
            if (empty($row['first_name'])) {
                $row['first_name'] = $nameParts[0] ?? '';
            }
            if (empty($row['last_name']) && count($nameParts) > 1) {
                $row['last_name'] = $nameParts[1] ?? '';
            }
        }

        // Generate password if not provided
        if (empty($row['password'])) {
            $row['password'] = Str::random(12);
        }

        // Hash the password
        $row['password'] = Hash::make($row['password']);

        // Convert string booleans to actual booleans
        $row['is_active'] = $this->convertToBoolean($row['is_active'] ?? true);

        // Handle email verification
        if ($this->convertToBoolean($row['email_verified'] ?? false)) {
            $row['email_verified_at'] = now();
        }
        unset($row['email_verified']);

        // Store roles for later assignment (after user creation)
        if (!empty($row['roles'])) {
            $row['_roles'] = array_map('trim', explode(',', $row['roles']));
        }
        unset($row['roles']);

        return $row;
    }

    protected function createRecord(array $data): void
    {
        // Extract roles before creating user
        $roleNames = $data['_roles'] ?? [];
        unset($data['_roles']);

        // Create user
        $user = User::create($data);

        // Assign roles if specified
        if (!empty($roleNames)) {
            $roles = Role::whereIn('name', $roleNames)->get();
            if ($roles->count() > 0) {
                $user->roles()->sync($roles->pluck('id')->toArray());
            }
        }
    }

    protected function convertToBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = strtolower(trim($value));
            return in_array($value, ['1', 'true', 'yes', 'on', 'active', 'verified']);
        }

        return (bool) $value;
    }

    protected function getSampleData(): array
    {
        return [
            [
                'name' => 'John Smith',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'john.smith@example.com',
                'password' => 'securepassword123',
                'roles' => 'admin, editor',
                'is_active' => 'Yes',
                'email_verified' => 'Yes'
            ],
            [
                'name' => 'Jane Doe',
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane.doe@example.com',
                'password' => 'anotherpassword456',
                'roles' => 'editor',
                'is_active' => 'Yes',
                'email_verified' => 'No'
            ],
            [
                'name' => 'Bob Wilson',
                'first_name' => 'Bob',
                'last_name' => 'Wilson',
                'email' => 'bob.wilson@example.com',
                'password' => '', // Will be auto-generated
                'roles' => 'user',
                'is_active' => 'Yes',
                'email_verified' => 'Yes'
            ]
        ];
    }
}