<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $permissionId = $this->route('permission')?->id;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\.]+$/',
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-\.]+$/',
                Rule::unique('permissions')->ignore($permissionId),
            ],
            'group' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-z0-9\-]+$/',
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The permission name is required.',
            'name.regex' => 'The permission name may only contain letters, numbers, spaces, hyphens, and dots.',
            'slug.required' => 'The permission slug is required.',
            'slug.regex' => 'The permission slug may only contain lowercase letters, numbers, hyphens, and dots.',
            'slug.unique' => 'This permission slug already exists.',
            'group.regex' => 'The permission group may only contain lowercase letters, numbers, and hyphens.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('name') && !$this->has('slug')) {
            $this->merge([
                'slug' => \Str::slug($this->name, '.'),
            ]);
        }
        
        if ($this->has('group')) {
            $this->merge([
                'group' => \Str::slug($this->group),
            ]);
        }
    }
}