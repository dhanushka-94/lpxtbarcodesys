# Barcode Printing System

## Overview
A professional barcode printing system for MSK Computers shop, integrated with the existing product database.

## Features

### ✅ User Authentication
- **Secure Login**: Email and password authentication
- **User Tracking**: Every print logged with user's name
- **Multi-User Support**: Create accounts for all staff
- **Session Management**: "Remember me" functionality
- **Easy User Creation**: Simple command-line tool
- **Default Admin**: admin@msk.com / password

### ✅ Print Logging & Reports
- **Automatic Logging**: Every barcode print is logged automatically
- **Detailed Reports**: View all print history with filters
- **Statistics Dashboard**: 
  - Total barcodes printed (all time)
  - Unique products printed
  - Today's print count
- **Advanced Filters**:
  - Filter by date range (start/end date)
  - Search by product code
  - Real-time filtering
- **Export to CSV**: Download filtered reports for Excel/analysis
- **Pagination**: Easy navigation through large datasets

### ✅ Full Product Names on Labels
- Product names now display up to 3 lines
- Automatic word wrapping
- No truncation - shows complete product name
- Maintains readable font size

### ✅ Auto-Suggest Search
- Type product code or name to see instant suggestions
- Dropdown shows product name, code, and price
- Click any suggestion to select that product
- Hover effects for better UX

### ✅ Product Selection
- Search results displayed in a table
- Select multiple products with checkboxes
- "Select All" checkbox for bulk selection
- Shows product code, name, price, and stock quantity
- Selected count display

### ✅ Multiple Copies
- Print multiple copies of each barcode
- Set copies from 1 to 50 per product
- Useful for bulk inventory labeling

### ✅ Barcode Labels
**Exact Size: 3.3cm (Width) × 2.1cm (Height)**

**Layout (Top to Bottom):**
1. Product Name (truncated if too long)
2. Product Price (Rs. format)
3. Barcode Image (CODE-128 format)
4. Product Code

**Print Layout:**
- 3 columns × 2 rows per page = 6 barcodes per page
- A4 paper size
- Automatic page breaks
- 1mm border for easy cutting

### ✅ Dark Theme UI
- Professional dark interface
- Black background (#121212)
- No bright colors
- Easy on the eyes for long working hours

## Database Configuration

### Main Database: `lpxtbarcode`
- Application data
- Users, sessions, cache
- Host: localhost (XAMPP)

### Products Database: `mskcomputers_m3klive`
- Read-only access
- Table: `sma_products`
- 604 products available
- Product codes, names, prices, stock levels

## How to Use

### 1. Start the Application
```bash
php artisan serve
```
Visit: http://localhost:8000

### 2. Login
- **Email**: admin@msk.com
- **Password**: password
- You'll be redirected to login automatically if not logged in
- See [AUTHENTICATION.md](AUTHENTICATION.md) for details

### 3. Search for Products
- Type at least 2 characters in the search box
- Auto-suggestions appear instantly
- Click a suggestion OR continue typing to see more results

### 4. Select Products
- Check the boxes for products you want to print
- Use "Select All" to select all visible products
- Set number of copies (default: 1)

### 5. Generate Barcodes
- Click "Generate Barcodes" button
- Review the barcode labels on screen
- Click "Print" to print
- Click "Back" to search for more products

### 6. Print Settings
- **Paper**: A4
- **Orientation**: Portrait
- **Margins**: 10mm
- **Print Preview**: Always preview before printing

## Technical Details

### Barcode Format
- **Type**: CODE-128 (most universal format)
- **Generated from**: Product Code only
- **Width**: 3 units
- **Height**: 50 pixels

### File Structure
```
app/
  Http/Controllers/BarcodeController.php  - Main controller
  Models/Product.php                      - Product model
resources/
  views/
    layouts/app.blade.php                 - Base layout
    barcode/index.blade.php               - Search interface
    barcode/print.blade.php               - Print layout
routes/web.php                            - Routes definition
```

### Routes
- `/` - Home (Search page)
- `/search` - AJAX product search
- `/generate` - Generate barcode labels (with logging)
- `/barcode/{code}` - Barcode image endpoint
- `/reports` - View print reports
- `/reports/export` - Export reports to CSV

## Keyboard Shortcuts
- **Ctrl+P** (on print page) - Quick print
- **Escape** - Close auto-suggest dropdown

## Viewing Print Reports

### Access Reports
1. Click "Print Reports" in the navigation menu
2. View summary statistics at the top
3. Use filters to narrow down results:
   - **Date Range**: Set start and end dates
   - **Product Code**: Search specific products
4. Click "Export to CSV" to download filtered results

### Report Information
Each log entry shows:
- Date and time of print
- Product code and name
- Price at time of printing
- Number of copies printed
- User who printed (currently "System User")

### Export Reports
- **Format**: CSV (opens in Excel)
- **Filename**: `barcode_print_logs_YYYY-MM-DD_HHMMSS.csv`
- **Contents**: All filtered records with headers
- **Use Cases**: 
  - Inventory audits
  - Print cost analysis
  - Product tracking
  - Monthly reports

## Tips

1. **For bulk printing**: Select all products in category and set copies to required amount
2. **For new products**: Search by product code for exact match
3. **For stock labeling**: Print multiple copies based on quantity received
4. **Label paper**: Use standard A4 label sheets or cut manually
5. **Track prints**: Use reports to monitor which products get printed most
6. **Export regularly**: Download monthly reports for record keeping

## Troubleshooting

### Search not working
- Check XAMPP MySQL is running
- Verify database connection in `.env`

### Barcodes not generating
- Check product codes exist in database
- Verify `sma_products` table has data

### Print size incorrect
- Ensure browser zoom is 100%
- Check printer settings (no scaling)
- Use Print Preview first

## Requirements
- PHP 8.1+
- MySQL 5.7+
- XAMPP
- Modern web browser (Chrome, Firefox, Edge)
- Printer (optional for testing)

## Support
For issues or enhancements, contact MSK Computers IT department.

