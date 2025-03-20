<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'categorizable_type'];

    public function categorizable(): MorphTo
    {
        return $this->morphTo();
    }
}
