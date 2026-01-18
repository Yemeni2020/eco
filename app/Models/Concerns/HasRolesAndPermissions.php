<?php

namespace App\Models\Concerns;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRolesAndPermissions
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'admin_role')->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'admin_permission')->withTimestamps();
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->contains('slug', $role);
    }

    public function hasPermissionTo(string $permission): bool
    {
        if ($this->permissions->contains('slug', $permission)) {
            return true;
        }

        return $this->roles->flatMap->permissions->contains('slug', $permission);
    }

    public function assignRole(...$roles): static
    {
        $slugs = $this->normalizeSlugs($roles);
        $models = Role::whereIn('slug', $slugs)->pluck('id')->all();
        $this->roles()->syncWithoutDetaching($models);

        return $this;
    }

    public function givePermissionTo(...$permissions): static
    {
        $slugs = $this->normalizeSlugs($permissions);
        $models = Permission::whereIn('slug', $slugs)->pluck('id')->all();
        $this->permissions()->syncWithoutDetaching($models);

        return $this;
    }

    protected function normalizeSlugs(array $values): array
    {
        return collect($values)
            ->flatten()
            ->map(fn ($value) => is_string($value) ? $value : ($value->slug ?? null))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
