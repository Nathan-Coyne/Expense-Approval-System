<?php

namespace App\Models;

use App\Traits\HasEntityPermissions;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasEntityPermissions;

    protected $table = 'platforms';

    protected $fillable = ['name'];
}
