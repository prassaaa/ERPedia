<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Company;
use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // Basic Information
    public $company_id = '';
    public $category_id = '';
    public $name = '';
    public $sku = '';
    public $barcode = '';
    public $description = '';
    public $type = 'product';
    public $unit_of_measure = 'pcs';

    // Pricing
    public $cost_price = 0;
    public $selling_price = 0;

    // Inventory
    public $minimum_stock = 0;
    public $maximum_stock = 0;
    public $track_inventory = true;

    // Physical Properties
    public $weight = '';
    public $dimensions = '';

    // Media
    public $image;

    // Settings
    public $is_active = true;

    protected function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'description' => 'nullable|string',
            'type' => 'required|in:product,service',
            'unit_of_measure' => 'required|string|max:20',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'required|integer|min:0|gte:minimum_stock',
            'track_inventory' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048', // 2MB max
            'is_active' => 'boolean',
        ];
    }

    protected $validationAttributes = [
        'company_id' => 'company',
        'category_id' => 'category',
        'name' => 'product name',
        'sku' => 'SKU',
        'barcode' => 'barcode',
        'cost_price' => 'cost price',
        'selling_price' => 'selling price',
        'minimum_stock' => 'minimum stock',
        'maximum_stock' => 'maximum stock',
        'unit_of_measure' => 'unit of measure',
        'track_inventory' => 'track inventory',
    ];

    public function updatedCompanyId()
    {
        // Reset category when company changes
        $this->category_id = '';
    }

    public function updatedType()
    {
        // Reset inventory tracking for services
        if ($this->type === 'service') {
            $this->track_inventory = false;
            $this->minimum_stock = 0;
            $this->maximum_stock = 0;
        } else {
            $this->track_inventory = true;
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $productData = [
                'company_id' => $this->company_id,
                'category_id' => $this->category_id,
                'name' => $this->name,
                'sku' => $this->sku,
                'barcode' => $this->barcode,
                'description' => $this->description,
                'type' => $this->type,
                'unit_of_measure' => $this->unit_of_measure,
                'cost_price' => $this->cost_price,
                'selling_price' => $this->selling_price,
                'minimum_stock' => $this->minimum_stock,
                'maximum_stock' => $this->maximum_stock,
                'track_inventory' => $this->track_inventory,
                'weight' => $this->weight ?: null,
                'dimensions' => $this->dimensions,
                'is_active' => $this->is_active,
            ];

            // Handle image upload
            if ($this->image) {
                $productData['image'] = $this->image->store('products', 'public');
            }

            $product = Product::create($productData);

            session()->flash('success', 'Product created successfully.');

            return redirect()->route('products.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $companies = Company::where('is_active', true)->get();

        $categories = collect();
        if ($this->company_id) {
            $categories = ProductCategory::where('company_id', $this->company_id)
                ->where('is_active', true)
                ->get();
        }

        return view('livewire.products.create', [
            'companies' => $companies,
            'categories' => $categories,
        ]);
    }
}
