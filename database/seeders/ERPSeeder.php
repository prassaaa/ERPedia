<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ChartOfAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ERPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles and Permissions
        $this->createRolesAndPermissions();

        // Create Company
        $company = $this->createCompany();

        // Create Departments
        $departments = $this->createDepartments($company);

        // Create Users
        $this->createUsers($company, $departments);

        // Create Leave Types
        $this->createLeaveTypes($company);

        // Create Warehouses
        $this->createWarehouses($company);

        // Create Product Categories and Products
        $this->createProductsAndCategories($company);

        // Create Chart of Accounts
        $this->createChartOfAccounts($company);
    }

    private function createRolesAndPermissions()
    {
        // Create permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'manage_companies',
            'manage_departments',
            'manage_products',
            'manage_inventory',
            'manage_accounting',
            'manage_leave_requests',
            'approve_leave_requests',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $managerRole->givePermissionTo([
            'view_dashboard',
            'manage_departments',
            'manage_leave_requests',
            'approve_leave_requests',
        ]);
        $employeeRole->givePermissionTo([
            'view_dashboard',
            'manage_leave_requests',
        ]);
    }

    private function createCompany()
    {
        return Company::create([
            'name' => 'ERPedia Demo Company',
            'code' => 'DEMO01',
            'description' => 'Demo company for ERPedia system',
            'email' => 'info@erpedia-demo.com',
            'phone' => '+1234567890',
            'website' => 'https://erpedia-demo.com',
            'address' => '123 Business Street',
            'city' => 'Business City',
            'state' => 'Business State',
            'country' => 'Business Country',
            'postal_code' => '12345',
            'tax_number' => 'TAX123456789',
            'is_active' => true,
        ]);
    }

    private function createDepartments($company)
    {
        $departments = [
            ['name' => 'Human Resources', 'code' => 'HR'],
            ['name' => 'Information Technology', 'code' => 'IT'],
            ['name' => 'Finance & Accounting', 'code' => 'FIN'],
            ['name' => 'Sales & Marketing', 'code' => 'SAL'],
            ['name' => 'Operations', 'code' => 'OPS'],
        ];

        $createdDepartments = [];
        foreach ($departments as $dept) {
            $createdDepartments[] = Department::create([
                'company_id' => $company->id,
                'name' => $dept['name'],
                'code' => $dept['code'],
                'description' => 'Department for ' . $dept['name'],
                'is_active' => true,
            ]);
        }

        return $createdDepartments;
    }

    private function createUsers($company, $departments)
    {
        // Create admin user
        $admin = User::create([
            'company_id' => $company->id,
            'department_id' => $departments[1]->id, // IT Department
            'employee_id' => 'EMP20250001',
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@erpedia.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
            'hire_date' => now()->subYears(2),
            'employment_status' => 'active',
            'employment_type' => 'full_time',
            'salary' => 80000,
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create manager users
        $manager1 = User::create([
            'company_id' => $company->id,
            'department_id' => $departments[0]->id, // HR Department
            'employee_id' => 'EMP20250002',
            'name' => 'HR Manager',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'hr.manager@erpedia.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567892',
            'hire_date' => now()->subYears(1),
            'employment_status' => 'active',
            'employment_type' => 'full_time',
            'salary' => 70000,
            'is_active' => true,
        ]);
        $manager1->assignRole('manager');

        // Update department managers
        $departments[0]->update(['manager_id' => $manager1->id]);
        $departments[1]->update(['manager_id' => $admin->id]);

        // Create regular employees
        $employees = [
            ['name' => 'John Doe', 'email' => 'john.doe@erpedia.com', 'dept' => 1],
            ['name' => 'Alice Johnson', 'email' => 'alice.johnson@erpedia.com', 'dept' => 2],
            ['name' => 'Bob Wilson', 'email' => 'bob.wilson@erpedia.com', 'dept' => 3],
            ['name' => 'Carol Brown', 'email' => 'carol.brown@erpedia.com', 'dept' => 4],
        ];

        foreach ($employees as $index => $emp) {
            $user = User::create([
                'company_id' => $company->id,
                'department_id' => $departments[$emp['dept']]->id,
                'employee_id' => 'EMP202500' . str_pad($index + 3, 2, '0', STR_PAD_LEFT),
                'name' => $emp['name'],
                'email' => $emp['email'],
                'password' => Hash::make('password'),
                'hire_date' => now()->subMonths(rand(3, 18)),
                'employment_status' => 'active',
                'employment_type' => 'full_time',
                'salary' => rand(45000, 65000),
                'is_active' => true,
            ]);
            $user->assignRole('employee');
        }
    }

    private function createLeaveTypes($company)
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'code' => 'AL', 'max_days' => 21, 'is_paid' => true],
            ['name' => 'Sick Leave', 'code' => 'SL', 'max_days' => 10, 'is_paid' => true],
            ['name' => 'Maternity Leave', 'code' => 'ML', 'max_days' => 90, 'is_paid' => true],
            ['name' => 'Paternity Leave', 'code' => 'PL', 'max_days' => 14, 'is_paid' => true],
            ['name' => 'Emergency Leave', 'code' => 'EL', 'max_days' => 5, 'is_paid' => false],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create([
                'company_id' => $company->id,
                'name' => $type['name'],
                'code' => $type['code'],
                'description' => $type['name'] . ' for employees',
                'max_days_per_year' => $type['max_days'],
                'is_paid' => $type['is_paid'],
                'requires_approval' => true,
                'is_active' => true,
            ]);
        }
    }

    private function createWarehouses($company)
    {
        $warehouses = [
            ['name' => 'Main Warehouse', 'code' => 'WH001', 'city' => 'Main City'],
            ['name' => 'Secondary Warehouse', 'code' => 'WH002', 'city' => 'Secondary City'],
        ];

        foreach ($warehouses as $wh) {
            Warehouse::create([
                'company_id' => $company->id,
                'name' => $wh['name'],
                'code' => $wh['code'],
                'description' => 'Storage facility for ' . $wh['name'],
                'address' => '123 Warehouse Street',
                'city' => $wh['city'],
                'state' => 'Warehouse State',
                'country' => 'Warehouse Country',
                'postal_code' => '54321',
                'phone' => '+1234567899',
                'email' => strtolower(str_replace(' ', '.', $wh['name'])) . '@erpedia.com',
                'is_active' => true,
            ]);
        }
    }

    private function createProductsAndCategories($company)
    {
        // Create categories
        $categories = [
            ['name' => 'Electronics', 'code' => 'ELEC'],
            ['name' => 'Computers', 'code' => 'COMP'],
            ['name' => 'Fashion', 'code' => 'FASH'],
            ['name' => 'Books', 'code' => 'BOOK'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = ProductCategory::create([
                'company_id' => $company->id,
                'name' => $cat['name'],
                'code' => $cat['code'],
                'description' => 'Category for ' . $cat['name'],
                'is_active' => true,
            ]);
        }

        // Create products
        $products = [
            ['name' => 'Boat Headphone', 'sku' => 'BH001', 'category' => 0, 'cost' => 50, 'selling' => 80],
            ['name' => 'MacBook Air M1', 'sku' => 'MBA001', 'category' => 1, 'cost' => 800, 'selling' => 1200],
            ['name' => 'Red Velvet Dress', 'sku' => 'RVD001', 'category' => 2, 'cost' => 30, 'selling' => 60],
            ['name' => 'Programming Book', 'sku' => 'PB001', 'category' => 3, 'cost' => 15, 'selling' => 25],
        ];

        foreach ($products as $prod) {
            Product::create([
                'company_id' => $company->id,
                'category_id' => $createdCategories[$prod['category']]->id,
                'name' => $prod['name'],
                'sku' => $prod['sku'],
                'description' => 'High quality ' . $prod['name'],
                'type' => 'product',
                'unit_of_measure' => 'pcs',
                'cost_price' => $prod['cost'],
                'selling_price' => $prod['selling'],
                'minimum_stock' => 10,
                'maximum_stock' => 100,
                'track_inventory' => true,
                'is_active' => true,
            ]);
        }
    }

    private function createChartOfAccounts($company)
    {
        $accounts = [
            // Assets
            ['code' => '1000', 'name' => 'Cash', 'type' => 'asset', 'subtype' => 'current_asset'],
            ['code' => '1100', 'name' => 'Accounts Receivable', 'type' => 'asset', 'subtype' => 'current_asset'],
            ['code' => '1200', 'name' => 'Inventory', 'type' => 'asset', 'subtype' => 'current_asset'],
            ['code' => '1500', 'name' => 'Equipment', 'type' => 'asset', 'subtype' => 'fixed_asset'],

            // Liabilities
            ['code' => '2000', 'name' => 'Accounts Payable', 'type' => 'liability', 'subtype' => 'current_liability'],
            ['code' => '2100', 'name' => 'Accrued Expenses', 'type' => 'liability', 'subtype' => 'current_liability'],

            // Equity
            ['code' => '3000', 'name' => 'Owner Equity', 'type' => 'equity', 'subtype' => 'owner_equity'],

            // Revenue
            ['code' => '4000', 'name' => 'Sales Revenue', 'type' => 'revenue', 'subtype' => 'operating_revenue'],

            // Expenses
            ['code' => '5000', 'name' => 'Cost of Goods Sold', 'type' => 'expense', 'subtype' => 'operating_expense'],
            ['code' => '5100', 'name' => 'Salaries Expense', 'type' => 'expense', 'subtype' => 'operating_expense'],
            ['code' => '5200', 'name' => 'Rent Expense', 'type' => 'expense', 'subtype' => 'operating_expense'],
        ];

        foreach ($accounts as $acc) {
            ChartOfAccount::create([
                'company_id' => $company->id,
                'account_code' => $acc['code'],
                'account_name' => $acc['name'],
                'account_type' => $acc['type'],
                'account_subtype' => $acc['subtype'],
                'description' => 'Account for ' . $acc['name'],
                'opening_balance' => 0,
                'current_balance' => 0,
                'is_active' => true,
            ]);
        }
    }
}
