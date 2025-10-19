# 🏷️ LAPTOP EXPERT Barcode Printing System

A professional, full-featured barcode printing system built with Laravel for retail/shop environments. Designed specifically for thermal roll printers (10.7cm width) with support for bulk continuous printing.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)
![License](https://img.shields.io/badge/license-MIT-green)

## ✨ Key Features

### 🔐 User Authentication
- Secure login system with email/password
- Multi-user support for staff accounts
- Session management with "Remember me"
- User tracking for all operations
- Easy user creation via command line

### 🏷️ Barcode Generation
- CODE-128 barcode format
- Auto-suggest product search
- Multiple product selection
- Bulk printing: 50-300 copies per product
- Full product name display (up to 3 lines)
- Real-time barcode preview

### 📊 Print Logging & Reports
- Automatic logging of all prints
- Track who printed what and when
- Advanced filtering (date range, product code)
- Statistics dashboard (total prints, today's prints)
- CSV export for analysis
- Complete audit trail

### 🖨️ Thermal Printer Support
- Optimized for 10.7cm (107mm) thermal roll printers
- Precise layout: 3 barcodes per row
- Exact sizing: 3.3cm × 2.1cm per barcode
- 2mm spacing between barcodes
- 3mm gap between rows
- Continuous roll printing

### 🎨 Professional UI/UX
- Dark theme interface
- Clean, modern design
- Responsive layout
- Real-time search suggestions
- Intuitive navigation
- Print preview

## 🚀 Quick Start

### Prerequisites
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- XAMPP (recommended) or similar local server

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/dhanushka-94/lpxtbarcodesys.git
cd lpxtbarcodesys
```

2. **Install dependencies**
```bash
composer install
```

3. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Update `.env` file**
```env
APP_NAME="LAPTOP EXPERT Barcode Printing System"

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lpxtbarcode
DB_USERNAME=root
DB_PASSWORD=

# Products Database (Read-Only)
PRODUCTS_DB_HOST=127.0.0.1
PRODUCTS_DB_PORT=3306
PRODUCTS_DB_DATABASE=your_products_database
PRODUCTS_DB_USERNAME=root
PRODUCTS_DB_PASSWORD=
```

5. **Create databases**
```sql
CREATE DATABASE lpxtbarcode;
-- Your products database should already exist
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **Create admin user**
```bash
php artisan db:seed --class=AdminUserSeeder
```

8. **Start the server**
```bash
php artisan serve
```

9. **Access the system**
- URL: http://localhost:8000
- Email: admin@msk.com
- Password: password

## 📖 Documentation

### Complete Guides
- **[BARCODE_SYSTEM.md](BARCODE_SYSTEM.md)** - Complete system documentation
- **[AUTHENTICATION.md](AUTHENTICATION.md)** - Authentication & user management
- **[LOGIN_SETUP.md](LOGIN_SETUP.md)** - Quick setup guide
- **[NEW_FEATURES.md](NEW_FEATURES.md)** - All features overview

### Database Structure

**Main Database:** `lpxtbarcode`
- `users` - User accounts
- `barcode_print_logs` - Print history
- `cache`, `sessions`, `jobs` - Laravel system tables

**Products Database:** Your existing products database
- Should contain `products` table with: code, name, price, quantity

## 🎯 Usage

### Daily Workflow
1. **Login** with your credentials
2. **Search** for products using code or name
3. **Select** products to print
4. **Set copies** (50-300 per product)
5. **Generate** barcodes
6. **Print** to thermal printer
7. System automatically logs with your name

### Creating Users
```bash
php artisan user:create
```

### Viewing Reports
- Go to "Print Reports" in navigation
- Filter by date or product
- Export to CSV

### Print Settings
- **Paper:** 10.7cm thermal roll
- **Layout:** 3 barcodes per row
- **Size:** 3.3cm × 2.1cm each
- **Format:** Continuous roll

## 🛠️ Tech Stack

- **Backend:** Laravel 12.x
- **Database:** MySQL with dual database support
- **Barcode:** picqer/php-barcode-generator (CODE-128)
- **Authentication:** Laravel built-in Auth
- **Frontend:** Blade templates with inline CSS/JS
- **No Build Process:** No Vite/Mix required

## 📂 Project Structure

```
lpxtbarcodesys/
├── app/
│   ├── Console/Commands/
│   │   └── CreateUser.php              # User creation command
│   ├── Http/Controllers/
│   │   ├── AuthController.php          # Login/logout
│   │   └── BarcodeController.php       # Main barcode logic
│   └── Models/
│       ├── Product.php                 # Products model
│       ├── BarcodePrintLog.php         # Logging model
│       └── User.php                    # User model
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php               # Main layout
│   ├── auth/
│   │   └── login.blade.php             # Login page
│   └── barcode/
│       ├── index.blade.php             # Search & select
│       ├── print.blade.php             # Print layout
│       └── reports.blade.php           # Reports dashboard
├── database/
│   ├── migrations/                     # Database migrations
│   └── seeders/
│       └── AdminUserSeeder.php         # Default admin
└── routes/
    └── web.php                         # Application routes
```

## 🔧 Configuration

### Barcode Settings
Edit `app/Http/Controllers/BarcodeController.php`:
- Barcode type: `TYPE_CODE_128`
- Width multiplier: `3`
- Height: `50` pixels

### Copy Limits
Edit `resources/views/barcode/index.blade.php` and `BarcodeController.php`:
- Minimum: `50`
- Maximum: `300`

### Paper Size
Edit `resources/views/barcode/print.blade.php`:
- Width: `107mm`
- Height: `auto` (continuous)

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Author

**Dhanushka**
- GitHub: [@dhanushka-94](https://github.com/dhanushka-94)

## 🙏 Acknowledgments

- Built for LAPTOP EXPERT retail operations
- Designed for MSK Computers product database integration
- Optimized for thermal roll printer environments

## 📞 Support

For issues or questions:
1. Check the documentation files
2. Open an issue on GitHub
3. Review the code comments

## 🚀 Deployment

### Production Checklist
- [ ] Change default admin password
- [ ] Update `.env` with production database credentials
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure proper session driver
- [ ] Set up SSL certificate
- [ ] Configure backup system
- [ ] Set up proper logging
- [ ] Test thermal printer connection

---

**Built with ❤️ for efficient retail barcode management**
