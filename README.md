# ERPedia - Enterprise Resource Planning System

ERPedia adalah sistem ERP (Enterprise Resource Planning) yang dibangun menggunakan Laravel 12, Livewire, dan template Modernize MUI yang telah diadaptasi. Sistem ini menyediakan solusi terintegrasi untuk manajemen perusahaan modern.

## 🚀 Fitur Utama

### 📊 Dashboard & Analytics
- Dashboard interaktif dengan KPI metrics
- Real-time statistics dan charts
- Responsive design dengan Material Design

### 👥 Human Resource Management (HRM)
- Manajemen karyawan lengkap
- Sistem cuti dan absensi
- Manajemen departemen
- Role-based access control

### 📦 Inventory Management
- Manajemen produk dan kategori
- Multi-warehouse support
- Stock tracking dan alerts
- Barcode support

### 💰 Accounting & Finance
- Chart of Accounts (COA)
- Jurnal umum dan buku besar
- Laporan keuangan
- Multi-company support

### 🏢 Company Management
- Multi-company architecture
- Company settings dan konfigurasi
- Audit trail untuk semua aktivitas

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Livewire + Blade Templates
- **Database**: SQLite (default), MySQL/PostgreSQL support
- **Styling**: Custom CSS dengan Material Design principles
- **Icons**: Material Icons
- **Authentication**: Laravel Breeze
- **Permissions**: Spatie Laravel Permission
- **Activity Log**: Spatie Laravel Activitylog
- **File Processing**: Laravel Excel, DomPDF

## 📋 Requirements

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL
- Web server (Apache/Nginx) atau Laravel Valet/Sail

## 🔧 Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd ERPedia
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env` dan sesuaikan konfigurasi database:

```env
# Untuk SQLite (default)
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

# Atau untuk MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erpedia
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration & Seeding
```bash
# Run migrations
php artisan migrate

# Seed database dengan data dummy
php artisan db:seed
```

### 6. Build Assets
```bash
# Build frontend assets
npm run build

# Atau untuk development
npm run dev
```

### 7. Start Development Server
```bash
# Start Laravel development server
php artisan serve

# Aplikasi akan tersedia di http://localhost:8000
```

## 👤 Default Users

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin User
- **Email**: admin@erpedia.com
- **Password**: password
- **Role**: Admin (Full Access)

### Manager User
- **Email**: hr.manager@erpedia.com
- **Password**: password
- **Role**: Manager (Limited Access)

### Employee Users
- **Email**: john.doe@erpedia.com, alice.johnson@erpedia.com, dll.
- **Password**: password
- **Role**: Employee (Basic Access)

## 🏗️ Architecture

### Directory Structure
```
app/
├── Contracts/          # Interface contracts
├── Http/Controllers/   # HTTP controllers
├── Models/            # Eloquent models
├── Repositories/      # Repository pattern implementation
├── Services/          # Business logic services
└── Livewire/         # Livewire components

resources/
├── views/
│   ├── layouts/       # Layout templates
│   ├── partials/      # Reusable components
│   └── modules/       # Module-specific views
├── css/              # Stylesheets
└── js/               # JavaScript files

database/
├── migrations/       # Database migrations
├── seeders/         # Database seeders
└── factories/       # Model factories
```

### Design Patterns
- **Repository Pattern**: Untuk abstraksi data access
- **Service Layer**: Untuk business logic
- **Observer Pattern**: Untuk activity logging
- **Factory Pattern**: Untuk object creation

## 🔐 Security Features

- **Authentication**: Laravel Breeze dengan session-based auth
- **Authorization**: Role & Permission based access control
- **CSRF Protection**: Built-in Laravel CSRF protection
- **SQL Injection Prevention**: Eloquent ORM protection
- **Activity Logging**: Comprehensive audit trail

## 📱 Responsive Design

Template telah diadaptasi dari Modernize MUI untuk memberikan:
- Mobile-first responsive design
- Touch-friendly interface
- Progressive Web App ready
- Cross-browser compatibility

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## 📈 Performance

- **Lazy Loading**: Eloquent relationships
- **Query Optimization**: N+1 query prevention
- **Caching**: Redis/File-based caching
- **Asset Optimization**: Vite build optimization

## 🔄 Development Workflow

### Adding New Modules
1. Create migration files
2. Create model dengan relationships
3. Create repository dan service
4. Create Livewire components
5. Add routes dan navigation
6. Create tests

### Code Standards
- Follow PSR-12 coding standards
- Use Laravel best practices
- Implement proper error handling
- Write comprehensive tests

## 🚀 Deployment

### Production Setup
```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### Environment Variables
Pastikan environment variables berikut diset untuk production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

Untuk bantuan dan support:
- Create issue di GitHub repository
- Email: support@erpedia.com
- Documentation: [Wiki](wiki-url)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - PHP Framework
- [Livewire](https://livewire.laravel.com) - Frontend Framework
- [Modernize MUI](https://themewagon.com/themes/modernize-mui/) - UI Template
- [Material Design](https://material.io) - Design System
- [Spatie](https://spatie.be) - Laravel Packages

---

**ERPedia** - Solusi ERP Modern untuk Bisnis Digital 🚀
