<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasPermission('users.roles');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $roleId = $this->route('role')?->id;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-]+$/',
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-]+$/',
                Rule::unique('roles')->ignore($roleId),
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'level' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'is_default' => [
                'boolean',
            ],
            'permissions' => [
                'nullable',
                'array',
            ],
            'permissions.*' => [
                'exists:permissions,id',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The role name is required.',
            'name.regex' => 'The role name may only contain letters, numbers, spaces, and hyphens.',
            'slug.required' => 'The role slug is required.',
            'slug.regex' => 'The role slug may only contain lowercase letters, numbers, and hyphens.',
            'slug.unique' => 'This role slug already exists.',
            'level.min' => 'The role level must be at least 0.',
            'level.max' => 'The role level cannot exceed 100.',
            'permissions.*.exists' => 'One or more selected permissions do not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('name') && !$this->has('slug')) {
            $this->merge([
                'slug' => \Str::slug($this->name),
            ]);
        }
    }
}