<?php

namespace App\Rules;

use Closure;
use App\Models\Service;
use Illuminate\Contracts\Validation\ValidationRule;

class PreventCircularServiceReference implements ValidationRule
{
    protected ?int $serviceId;

    /**
     * Create a new rule instance.
     *
     * @param int|null $serviceId The ID of the service being updated
     */
    public function __construct(?int $serviceId = null)
    {
        $this->serviceId = $serviceId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // If no parent is set, no circular reference is possible
        if (!$value) {
            return;
        }

        // If we're creating a new service (no ID), just check if parent exists
        if (!$this->serviceId) {
            if (!Service::find($value)) {
                $fail('The selected parent service does not exist.');
            }
            return;
        }

        // Check for self-reference
        if ($value == $this->serviceId) {
            $fail('A service cannot be its own parent.');
            return;
        }

        // Check if the selected parent is a descendant of the current service
        if ($this->isDescendant($value, $this->serviceId)) {
            $fail('The selected parent service would create a circular reference.');
        }
    }

    /**
     * Check if a service is a descendant of another service
     *
     * @param int $serviceId The service to check
     * @param int $ancestorId The potential ancestor
     * @return bool
     */
    protected function isDescendant(int $serviceId, int $ancestorId): bool
    {
        $service = Service::find($serviceId);
        
        if (!$service) {
            return false;
        }

        // Traverse up the parent chain
        $currentParent = $service->parent;
        $depth = 0;
        $maxDepth = 100; // Prevent infinite loops

        while ($currentParent && $depth < $maxDepth) {
            if ($currentParent->id == $ancestorId) {
                return true;
            }
            $currentParent = $currentParent->parent;
            $depth++;
        }

        return false;
    }
}
