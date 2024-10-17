<?php
namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role): bool
    {
        return $this->roles()->get()->contains(Role::wrap($role));
    }

    public function hasRoles(...$roles): bool
    {
        foreach (Arr::flatten($roles) as $role) {
            if (! $this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    public function hasAnyRole(...$roles): bool
    {
        foreach (Arr::flatten($roles) as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    public function addRole($role): void
    {
        $this->roles()->attach(Role::wrap($role));
    }

    public function removeRole($role): void
    {
        $this->roles()->detach(Role::wrap($role));
    }

    public function scopeWhereRole(Builder $query, $role): Builder
    {
        return $query->whereHas('roles', function($query) use ($role) {
            return $query->where(DB::raw('"roles"."id"'), Role::wrap($role)->id);
        });
    }
}
