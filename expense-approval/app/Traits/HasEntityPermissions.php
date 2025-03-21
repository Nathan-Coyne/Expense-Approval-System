<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Permission;

trait HasEntityPermissions
{
    public function grantees($class): MorphToMany
    {
        return $this->morphToMany(
            $class,
            'granter',
            'entity_entity_permissions',
            'granter_id',
            'grantee_id'
        )
            ->wherePivot('grantee_type', $class)
            ->withPivot('permission_id');

    }

    public function granteeWithPermission($class, string $permissionName): MorphToMany
    {
        $permission = Permission::where('name', $permissionName)->first();

        return $this->grantees($class)
            ->wherePivot('permission_id', $permission->id);
    }

    public function hasGranteeGotPermission($class, $permissionName): bool
    {
        return $this->granteeWithPermission($class, $permissionName)->exists();
    }

    public function granted($class): MorphToMany
    {
        return $this->morphToMany(
            $class,
            'grantee',
            'entity_entity_permissions',
            'grantee_id',
            'granter_id'
        )
            ->wherePivot('granter_type', $class)
            ->withPivot('permission_id');
    }

    public function grantedWithPermission($class, string $permissionName): MorphToMany
    {
        $permission = Permission::where('name', $permissionName)->first();

        return $this->granted($class)
            ->wherePivot('permission_id', $permission->id);
    }

    public function hasGrantedGotPermission($class, $permissionName): bool
    {
        return $this->grantedWithPermission($class, $permissionName)->exists();
    }
}
