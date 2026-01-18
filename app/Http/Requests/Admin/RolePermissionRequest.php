<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    protected function prepareForValidation(): void
    {
        $roles = collect($this->input('roles', []))->mapWithKeys(function ($payload, $slug) {
            $permissions = array_filter((array) ($payload['permissions'] ?? []));

            return [$slug => [
                'permissions' => array_values($permissions),
            ]];
        })->all();

        $this->merge(['roles' => $roles]);
    }

    public function rules(): array
    {
        return [
            'roles' => ['array'],
            'roles.*.permissions' => ['array'],
            'roles.*.permissions.*' => ['string', Rule::exists('permissions', 'slug')],
        ];
    }
}
