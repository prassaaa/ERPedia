<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first company for seeding
        $company = Company::first();

        if (!$company) {
            $this->command->error('No companies found. Please run CompanySeeder first.');
            return;
        }

        // Get categories
        $smartphoneCategory = ProductCategory::where('name', 'Smartphones')->first();
        $laptopCategory = ProductCategory::where('name', 'Laptops')->first();
        $accessoryCategory = ProductCategory::where('name', 'Accessories')->first();
        $consultingCategory = ProductCategory::where('name', 'Consulting')->first();

        if (!$smartphoneCategory || !$laptopCategory || !$accessoryCategory || !$consultingCategory) {
            $this->command->error('Product categories not found. Please run ProductCategorySeeder first.');
            return;
        }

        // Create sample products
        $products = [
            // Smartphones
            [
                'company_id' => $company->id,
                'category_id' => $smartphoneCategory->id,
                'name' => 'iPhone 15 Pro',
                'sku' => 'IPH15PRO001',
                'barcode' => '1234567890123',
                'description' => 'Latest iPhone with advanced camera system and A17 Pro chip',
                'type' => 'product',
                'unit_of_measure' => 'pcs',
                'cost_price' => 800.00,
                'selling_price' => 1199.00,
                'minimum_stock' => 10,
                'maximum_stock' => 100,
                'track_inventory' => true,
                'weight' => 0.187,
                'dimensions' => '14.67 x 7.08 x 0.83 cm',
                'is_active' => true,
            ],
            [
                'company_id' => $company->id,
                'category_id' => $smartphoneCategory->id,
                'name' => 'Samsung Galaxy S24',
                'sku' => 'SAM24001',
                'barcode' => '2345678901234',
                'description' => 'Premium Android smartphone with AI features',
                'type' => 'product',
                'unit_of_measure' => 'pcs',
                'cost_price' => 700.00,
                'selling_price' => 999.00,
                'minimum_stock' => 15,
                'maximum_stock' => 80,
                'track_inventory' => true,
                'weight' => 0.168,
                'dimensions' => '14.7 x 7.06 x 0.76 cm',
                'is_active' => true,
            ],

            // Laptops
            [
                'company_id' => $company->id,
                'category_id' => $laptopCategory->id,
                'name' => 'MacBook Pro 14"',
                'sku' => 'MBP14001',
                'barcode' => '3456789012345',
                'description' => 'Professional laptop with M3 Pro chip',
                'type' => 'product',
                'unit_of_measure' => 'pcs',
                'cost_price' => 1800.00,
                'selling_price' => 2499.00,
                'minimum_stock' => 5,
                'maximum_stock' => 30,
                'track_inventory' => true,
                'weight' => 1.6,
                'dimensions' => '31.26 x 22.12 x 1.55 cm',
                'is_active' => true,
            ],
            [
                'company_id' => $company->id,
                'category_id' => $laptopCategory->id,
                'name' => 'Dell XPS 13',
                'sku' => 'DELL13001',
                'barcode' => '4567890123456',
                'description' => 'Ultra-portable laptop with Intel Core i7',
                'type' => 'product',
                'unit_of_measure' => 'pcs',
                'cost_price' => 1200.00,
                'selling_price' => 1699.00,
                'minimum_stock' => 8,
                'maximum_stock' => 40,
                'track_inventory' => true,
                'weight' => 1.27,
                'dimensions' => '29.57 x 19.85 x 1.48 cm',
                'is_active' => true,
            ],

            // Accessories
            [
                'company_id' => $company->id,
                'category_id' => $accessoryCategory->id,
                'name' => 'Wireless Mouse',
                'sku' => 'MOUSE001',
                'barcode' => '5678901234567',
                'description' => 'Ergonomic wireless mouse with precision tracking',
                'type' => 'product',
                'unit_of_measure' => 'pcs',
                'cost_price' => 25.00,
                'selling_price' => 49.99,
                'minimum_stock' => 50,
                'maximum_stock' => 200,
                'track_inventory' => true,
                'weight' => 0.1,
                'dimensions' => '11.5 x 6.2 x 3.8 cm',
                'is_active' => true,
            ],
            [
                'company_id' => $company->id,
                'category_id' => $accessoryCategory->id,
                'name' => 'USB-C Hub',
                'sku' => 'HUB001',
                'barcode' => '6789012345678',
                'description' => '7-in-1 USB-C hub with HDMI, USB ports, and SD card reader',
                'type' => 'product',
                'unit_of_measure' => 'pcs',
                'cost_price' => 35.00,
                'selling_price' => 79.99,
                'minimum_stock' => 30,
                'maximum_stock' => 150,
                'track_inventory' => true,
                'weight' => 0.15,
                'dimensions' => '12 x 4.5 x 1.2 cm',
                'is_active' => true,
            ],

            // Services
            [
                'company_id' => $company->id,
                'category_id' => $consultingCategory->id,
                'name' => 'IT Consulting',
                'sku' => 'CONSULT001',
                'description' => 'Professional IT consulting and system design services',
                'type' => 'service',
                'unit_of_measure' => 'hour',
                'cost_price' => 80.00,
                'selling_price' => 150.00,
                'minimum_stock' => 0,
                'maximum_stock' => 0,
                'track_inventory' => false,
                'is_active' => true,
            ],
            [
                'company_id' => $company->id,
                'category_id' => $consultingCategory->id,
                'name' => 'Software Development',
                'sku' => 'DEV001',
                'description' => 'Custom software development and programming services',
                'type' => 'service',
                'unit_of_measure' => 'hour',
                'cost_price' => 100.00,
                'selling_price' => 180.00,
                'minimum_stock' => 0,
                'maximum_stock' => 0,
                'track_inventory' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Products seeded successfully.');
    }
}
