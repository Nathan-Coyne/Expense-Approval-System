<?php

namespace App\Models;

use App\Traits\HasPlatformPermissions;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasPlatformPermissions;

    protected $table = 'platforms';

    protected $fillable = ['name'];
}
