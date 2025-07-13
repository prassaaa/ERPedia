<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
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

        // Create root categories
        $electronics = ProductCategory::create([
            'company_id' => $company->id,
            'name' => 'Electronics',
            'code' => 'ELEC',
            'description' => 'Electronic devices and components',
            'is_active' => true,
        ]);

        $clothing = ProductCategory::create([
            'company_id' => $company->id,
            'name' => 'Clothing & Apparel',
            'code' => 'CLOTH',
            'description' => 'Clothing, shoes, and accessories',
            'is_active' => true,
        ]);

        $books = ProductCategory::create([
            'company_id' => $company->id,
            'name' => 'Books & Media',
            'code' => 'BOOKS',
            'description' => 'Books, magazines, and digital media',
            'is_active' => true,
        ]);

        $services = ProductCategory::create([
            'company_id' => $company->id,
            'name' => 'Services',
            'code' => 'SERV',
            'description' => 'Professional and consulting services',
            'is_active' => true,
        ]);

        // Create subcategories for Electronics
        ProductCategory::create([
            'company_id' => $company->id,
            'parent_id' => $electronics->id,
            'name' => 'Smartphones',
            'code' => 'PHONE',
            'description' => 'Mobile phones and smartphones',
            'is_active' => true,
        ]);

        ProductCategory::create([
            'company_id' => $company->id,
            'parent_id' => $electronics->id,
            'name' => 'Laptops',
            'code' => 'LAPTOP',
            'description' => 'Laptops and notebooks',
            'is_active' => true,
        ]);

        ProductCategory::create([
            'company_id' => $company->id,
            'parent_id' => $electronics->id,
            'name' => 'Accessories',
            'code' => 'ACC',
            'description' => 'Electronic accessories and peripherals',
            'is_active' => true,
        ]);

        // Create subcategories for Clothing
        ProductCategory::create([
            'company_id' => $company->id,
            'parent_id' => $clothing->id,
            'name' => 'Men\'s Clothing',
            'code' => 'MENS',
            'description' => 'Men\'s clothing and accessories',
            'is_active' => true,
        ]);

        ProductCategory::create([
            'company_id' => $company->id,
            'parent_id' => $clothing->id,
            'name' => 'Women\'s Clothing',
            'code' => 'WOMENS',
            'description' => 'Women\'s clothing and accessories',
            'is_active' => true,
        ]);

        // Create subcategories for Services
        ProductCategory::create([
            'company_id' => $company->id,
            'parent_id' => $services->id,
            'name' => 'Consulting',
            'code' => 'CONSULT',
            'description' => 'Business and technical consulting',
            'is_active' => true,
        ]);

        ProductCategory::create([
            'company_id' => $company->id,
            'parent_id' => $services->id,
            'name' => 'Support',
            'code' => 'SUPPORT',
            'description' => 'Technical support and maintenance',
            'is_active' => true,
        ]);

        $this->command->info('Product categories seeded successfully.');
    }
}
