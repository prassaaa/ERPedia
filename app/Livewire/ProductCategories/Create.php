<?php

namespace App\Livewire\ProductCategories;

use App\Models\ProductCategory;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // Basic Information
    public $company_id = '';
    public $parent_id = '';
    public $name = '';
    public $code = '';
    public $description = '';
    public $image;

    // Settings
    public $is_active = true;

    protected function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'parent_id' => 'nullable|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:product_categories,code',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB max
            'is_active' => 'boolean',
        ];
    }

    protected $validationAttributes = [
        'company_id' => 'company',
        'parent_id' => 'parent category',
        'name' => 'category name',
        'code' => 'category code',
        'image' => 'category image',
    ];

    public function updatedCompanyId()
    {
        // Reset parent category when company changes
        $this->parent_id = '';
    }

    public function save()
    {
        $this->validate();

        try {
            $categoryData = [
                'company_id' => $this->company_id,
                'parent_id' => $this->parent_id ?: null,
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ];

            // Handle image upload
            if ($this->image) {
                $categoryData['image'] = $this->image->store('product-categories', 'public');
            }

            $category = ProductCategory::create($categoryData);

            session()->flash('success', 'Product category created successfully.');

            return redirect()->route('product-categories.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating category: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $companies = Company::where('is_active', true)->get();

        $parentCategories = collect();
        if ($this->company_id) {
            $parentCategories = ProductCategory::where('company_id', $this->company_id)
                ->where('is_active', true)
                ->get();
        }

        return view('livewire.product-categories.create', [
            'companies' => $companies,
            'parentCategories' => $parentCategories,
        ]);
    }
}
