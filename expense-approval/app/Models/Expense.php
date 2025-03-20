<?php

namespace App\Models;

use App\Models\Category\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Expense extends Model
{   use HasFactory;
    protected $fillable = [
        'description',
        'amount',
        'user_id',
        'category_id',
        'file_id'
    ];

    public function statuses(): MorphToMany
    {
        return $this->morphToMany(
            Status::class,
            'model', // This matches the "model" prefix in the pivot table
            'models_has_statuses' // Pivot table name
        )->withTimestamps();
    }

    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function expenseCategory(): HasOne
    {
        return $this->hasOne(ExpenseCategory::class, 'id', 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id',  'id');
    }

    public function getAmountFormattedAttribute(): string
    {
        return '£' . number_format($this->amount / 100, 2);
    }
}
