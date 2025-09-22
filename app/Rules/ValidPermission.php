<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Permission;

class ValidPermission implements ValidationRule
{
    protected $allowMultiple;
    protected $requiredGroup;
    protected $errorMessage;

    public function __construct(bool $allowMultiple = false, ?string $requiredGroup = null)
    {
        $this->allowMultiple = $allowMultiple;
        $this->requiredGroup = $requiredGroup;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->allowMultiple && is_array($value)) {
            foreach ($value as $permissionValue) {
                if (!$this->isValidPermission($permissionValue)) {
                    $fail($this->errorMessage ?: "The {$attribute} contains an invalid permission.");
                    return;
                }
            }
        } else {
            if (!$this->isValidPermission($value)) {
                $fail($this->errorMessage ?: "The selected {$attribute} is invalid.");
            }
        }
    }

    /**
     * Check if a permission is valid
     */
    protected function isValidPermission($value): bool
    {
        if (empty($value)) {
            $this->errorMessage = 'Permission cannot be empty.';
            return false;
        }

        $permission = null;

        if (is_numeric($value)) {
            $permission = Permission::find($value);
        } elseif (is_string($value)) {
            $permission = Permission::where('slug', $value)->first();
        }

        if (!$permission) {
            $this->errorMessage = "Permission '{$value}' does not exist.";
            return false;
        }

        // Check if permission belongs to required group
        if ($this->requiredGroup && $permission->group !== $this->requiredGroup) {
            $this->errorMessage = "Permission must belong to the '{$this->requiredGroup}' group.";
            return false;
        }

        return true;
    }
}