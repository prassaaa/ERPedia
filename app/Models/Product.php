<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    protected $fillable = [
        'company_id',
        'category_id',
        'name',
        'sku',
        'barcode',
        'description',
        'type',
        'unit_of_measure',
        'cost_price',
        'selling_price',
        'minimum_stock',
        'maximum_stock',
        'track_inventory',
        'image',
        'images',
        'weight',
        'dimensions',
        'is_active',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'minimum_stock' => 'integer',
        'maximum_stock' => 'integer',
        'track_inventory' => 'boolean',
        'images' => 'array',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the company that owns the product.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Scope a query to only include products.
     */
    public function scopeProducts($query)
    {
        return $query->where('type', 'product');
    }

    /**
     * Scope a query to only include services.
     */
    public function scopeServices($query)
    {
        return $query->where('type', 'service');
    }

    /**
     * Scope a query to only include products that track inventory.
     */
    public function scopeTrackInventory($query)
    {
        return $query->where('track_inventory', true);
    }

    /**
     * Check if the product is a physical product.
     */
    public function isProduct(): bool
    {
        return $this->type === 'product';
    }

    /**
     * Check if the product is a service.
     */
    public function isService(): bool
    {
        return $this->type === 'service';
    }

    /**
     * Get the profit margin.
     */
    public function getProfitMarginAttribute(): float
    {
        if ($this->cost_price == 0) {
            return 0;
        }
        
        return (($this->selling_price - $this->cost_price) / $this->cost_price) * 100;
    }
}
