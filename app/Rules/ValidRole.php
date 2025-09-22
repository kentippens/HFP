<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Role;

class ValidRole implements ValidationRule
{
    protected $allowMultiple;
    protected $checkLevel;
    protected $errorMessage;

    public function __construct(bool $allowMultiple = false, bool $checkLevel = true)
    {
        $this->allowMultiple = $allowMultiple;
        $this->checkLevel = $checkLevel;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->allowMultiple && is_array($value)) {
            foreach ($value as $roleValue) {
                if (!$this->isValidRole($roleValue)) {
                    $fail($this->errorMessage ?: "The {$attribute} contains an invalid role.");
                    return;
                }
            }
        } else {
            if (!$this->isValidRole($value)) {
                $fail($this->errorMessage ?: "The selected {$attribute} is invalid.");
            }
        }
    }

    /**
     * Check if a role is valid
     */
    protected function isValidRole($value): bool
    {
        if (empty($value)) {
            $this->errorMessage = 'Role cannot be empty.';
            return false;
        }

        $role = null;

        if (is_numeric($value)) {
            $role = Role::find($value);
        } elseif (is_string($value)) {
            $role = Role::where('slug', $value)->first();
        }

        if (!$role) {
            $this->errorMessage = "Role '{$value}' does not exist.";
            return false;
        }

        // Check if current user can assign this role
        if ($this->checkLevel && auth()->check() && !auth()->user()->isSuperAdmin()) {
            $currentUserLevel = auth()->user()->roles()->max('level') ?? 0;
            if ($role->level > $currentUserLevel) {
                $this->errorMessage = "You cannot assign a role with a higher level than your own.";
                return false;
            }
        }

        return true;
    }
}