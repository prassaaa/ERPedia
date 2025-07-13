<?php

namespace App\Livewire\ProductCategories;

use App\Models\ProductCategory;
use App\Models\Company;
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
    public $status_filter = '';

    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'company_filter' => ['except' => ''],
        'status_filter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCompanyFilter()
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

    public function deleteCategory($categoryId)
    {
        $category = ProductCategory::findOrFail($categoryId);

        // Check if category has products
        if ($category->products()->count() > 0) {
            session()->flash('error', 'Cannot delete category with existing products. Please move or remove products first.');
            return;
        }

        // Check if category has child categories
        if ($category->children()->count() > 0) {
            session()->flash('error', 'Cannot delete category with child categories. Please move or remove child categories first.');
            return;
        }

        $category->delete();
        session()->flash('success', 'Product category deleted successfully.');
    }

    public function toggleCategoryStatus($categoryId)
    {
        $category = ProductCategory::findOrFail($categoryId);
        $category->update(['is_active' => !$category->is_active]);

        session()->flash('success', 'Category status updated successfully.');
    }

    public function render()
    {
        $categories = ProductCategory::query()
            ->with(['company', 'parent'])
            ->withCount(['products', 'children'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->company_filter, function ($query) {
                $query->where('company_id', $this->company_filter);
            })
            ->when($this->status_filter, function ($query) {
                if ($this->status_filter === 'active') {
                    $query->where('is_active', true);
                } else {
                    $query->where('is_active', false);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        // Get companies for filter
        $companies = Company::where('is_active', true)->get();

        return view('livewire.product-categories.index', [
            'categories' => $categories,
            'companies' => $companies,
        ]);
    }
}
