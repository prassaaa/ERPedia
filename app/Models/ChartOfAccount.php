<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChartOfAccount extends BaseModel
{
    protected $fillable = [
        'company_id',
        'account_code',
        'account_name',
        'account_type',
        'account_subtype',
        'parent_id',
        'description',
        'opening_balance',
        'current_balance',
        'is_active',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the company that owns the account.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the parent account.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    /**
     * Get the child accounts.
     */
    public function children(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id');
    }

    /**
     * Scope a query to only include assets.
     */
    public function scopeAssets($query)
    {
        return $query->where('account_type', 'asset');
    }

    /**
     * Scope a query to only include liabilities.
     */
    public function scopeLiabilities($query)
    {
        return $query->where('account_type', 'liability');
    }

    /**
     * Scope a query to only include equity accounts.
     */
    public function scopeEquity($query)
    {
        return $query->where('account_type', 'equity');
    }

    /**
     * Scope a query to only include revenue accounts.
     */
    public function scopeRevenue($query)
    {
        return $query->where('account_type', 'revenue');
    }

    /**
     * Scope a query to only include expense accounts.
     */
    public function scopeExpenses($query)
    {
        return $query->where('account_type', 'expense');
    }

    /**
     * Check if the account is an asset.
     */
    public function isAsset(): bool
    {
        return $this->account_type === 'asset';
    }

    /**
     * Check if the account is a liability.
     */
    public function isLiability(): bool
    {
        return $this->account_type === 'liability';
    }

    /**
     * Check if the account is equity.
     */
    public function isEquity(): bool
    {
        return $this->account_type === 'equity';
    }

    /**
     * Check if the account is revenue.
     */
    public function isRevenue(): bool
    {
        return $this->account_type === 'revenue';
    }

    /**
     * Check if the account is an expense.
     */
    public function isExpense(): bool
    {
        return $this->account_type === 'expense';
    }
}
