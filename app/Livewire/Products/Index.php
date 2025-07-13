<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Company;
use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $company_filter = '';

    #[Url]
    public $category_filter = '';

    #[Url]
    public $type_filter = '';

    #[Url]
    public $status_filter = '';

    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'company_filter' => ['except' => ''],
        'category_filter' => ['except' => ''],
        'type_filter' => ['except' => ''],
        'status_filter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCompanyFilter()
    {
        $this->resetPage();
        $this->category_filter = ''; // Reset category when company changes
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
        $this->resetPage();
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);

        // Check if product has inventory records
        // Note: We'll implement this check when we have inventory relationships

        $product->delete();
        session()->flash('success', 'Product deleted successfully.');
    }

    public function toggleProductStatus($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_active' => !$product->is_active]);

        session()->flash('success', 'Product status updated successfully.');
    }

    public function render()
    {
        $products = Product::query()
            ->with(['company', 'category'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%')
                      ->orWhere('barcode', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->company_filter, function ($query) {
                $query->where('company_id', $this->company_filter);
            })
            ->when($this->category_filter, function ($query) {
                $query->where('category_id', $this->category_filter);
            })
            ->when($this->type_filter, function ($query) {
                $query->where('type', $this->type_filter);
            })
            ->when($this->status_filter, function ($query) {
                if ($this->status_filter === 'active') {
                    $query->where('is_active', true);
                } else {
                    $query->where('is_active', false);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        // Get filter options
        $companies = Company::where('is_active', true)->get();

        $categories = collect();
        if ($this->company_filter) {
            $categories = ProductCategory::where('company_id', $this->company_filter)
                ->where('is_active', true)
                ->get();
        }

        return view('livewire.products.index', [
            'products' => $products,
            'companies' => $companies,
            'categories' => $categories,
        ]);
    }
}
