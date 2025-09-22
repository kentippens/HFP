<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class RbacException extends Exception
{
    protected $context = [];

    public function __construct($message = "", $code = 0, $context = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
        $this->logError();
    }

    /**
     * Log the error with context
     */
    protected function logError(): void
    {
        Log::error('RBAC Exception: ' . $this->getMessage(), array_merge($this->context, [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
        ]));
    }

    /**
     * Get the context data
     */
    public function getContext(): array
    {
        return $this->context;
    }
}

class RoleNotFoundException extends RbacException
{
    public function __construct($role, $context = [])
    {
        $message = "Role not found: {$role}";
        parent::__construct($message, 404, array_merge($context, ['role' => $role]));
    }
}

class PermissionNotFoundException extends RbacException
{
    public function __construct($permission, $context = [])
    {
        $message = "Permission not found: {$permission}";
        parent::__construct($message, 404, array_merge($context, ['permission' => $permission]));
    }
}

class InvalidRoleException extends RbacException
{
    public function __construct($message, $context = [])
    {
        parent::__construct($message, 422, $context);
    }
}

class InvalidPermissionException extends RbacException
{
    public function __construct($message, $context = [])
    {
        parent::__construct($message, 422, $context);
    }
}

class UnauthorizedRoleAssignmentException extends RbacException
{
    public function __construct($role, $context = [])
    {
        $message = "Unauthorized attempt to assign role: {$role}";
        parent::__construct($message, 403, array_merge($context, ['role' => $role]));
    }
}

class CircularRoleHierarchyException extends RbacException
{
    public function __construct($roles, $context = [])
    {
        $message = "Circular role hierarchy detected";
        parent::__construct($message, 422, array_merge($context, ['roles' => $roles]));
    }
}

class RoleAssignmentException extends RbacException
{
    public function __construct($message, $context = [])
    {
        parent::__construct($message, 500, $context);
    }
}