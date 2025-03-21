<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    public function getUsers() : BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_permission',
            'permission_id',
            'user_id'
        );
    }
}
