<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product->load(['company', 'category']);
    }

    public function toggleProductStatus()
    {
        $this->product->update([
            'is_active' => !$this->product->is_active
        ]);

        $this->product->refresh();
        session()->flash('success', 'Product status updated successfully.');
    }

    public function render()
    {
        // Get product statistics (placeholder for future inventory integration)
        $stats = [
            'current_stock' => 0, // Will be calculated from inventory
            'reserved_stock' => 0, // Will be calculated from inventory
            'available_stock' => 0, // Will be calculated from inventory
            'total_value' => 0, // Will be calculated from inventory
        ];

        return view('livewire.products.show', [
            'stats' => $stats,
        ]);
    }
}
