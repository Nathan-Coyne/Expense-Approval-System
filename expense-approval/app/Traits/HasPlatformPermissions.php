<?php
namespace App\Traits;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Permission;

trait HasPlatformPermissions
{
    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'grantee', 'entity_entity_permissions', 'grantee_id', 'permission_id')
            ->where('grantee_type', self::class);
    }

    public function platformPermissions()
    {
        return $this->morphToMany(Permission::class, 'grantee', 'entity_entity_permissions', 'grantee_id', 'permission_id')
            ->where('grantee_type', self::class)->where('granter_type', Platform::class);
    }

    public function grantedPermissions()
    {
        return $this->morphToMany(Permission::class, 'granter', 'entity_entity_permissions', 'granter_id', 'permission_id')
            ->where('granter_type', self::class);
    }

    public function hasPermission(Permission $permission)
    {
        return $this->permissions->contains(function ($p) use ($permission) {
            return $p->name === $permission->name
                && $p->description === $permission->description;
        });
    }

    public function hasPlatformPermission(Permission $permission)
    {
        return $this->platformPermissions->contains(function ($p) use ($permission) {
            return $p->name === $permission->name
                && $p->description === $permission->description;
        });
    }

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
