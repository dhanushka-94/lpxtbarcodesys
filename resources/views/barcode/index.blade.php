@extends('layouts.app')

@section('title', 'Dashboard - LAPTOP EXPERT Barcode Printing System')

@push('styles')
<style>
    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .dashboard-subtitle {
        color: #b0b0b0;
        font-size: 14px;
        margin-bottom: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(135deg, #2a2a2a 0%, #1e1e1e 100%);
        border: 1px solid #3a3a3a;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #4a9eff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 158, 255, 0.15);
    }

    .stat-label {
        font-size: 12px;
        color: #b0b0b0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #4a9eff;
        line-height: 1;
    }

    .search-section {
        background: #1e1e1e;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .search-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .search-icon {
        width: 24px;
        height: 24px;
        color: #4a9eff;
    }

    .search-title {
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }

    .enhanced-input {
        position: relative;
    }

    .enhanced-input input {
        width: 100%;
        padding: 14px 16px 14px 45px;
        background: #2a2a2a;
        border: 2px solid #3a3a3a;
        border-radius: 8px;
        color: #e0e0e0;
        font-size: 15px;
        transition: all 0.2s;
    }

    .enhanced-input input:focus {
        outline: none;
        border-color: #4a9eff;
        background: #252525;
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.1);
    }

    .search-input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6a6a6a;
        pointer-events: none;
    }

    .suggestions-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #2a2a2a;
        border: 2px solid #4a9eff;
        border-top: none;
        border-radius: 0 0 8px 8px;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    }

    .results-section {
        background: #1e1e1e;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
    }

    .copies-section {
        background: linear-gradient(135deg, #2a2a2a 0%, #252525 100%);
        border: 1px solid #3a3a3a;
        border-radius: 8px;
        padding: 18px 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .copies-label {
        color: #e0e0e0;
        font-size: 14px;
        font-weight: 500;
        margin: 0;
    }

    .copies-input {
        width: 100px;
        padding: 10px 14px;
        background: #1e1e1e;
        border: 1px solid #4a4a4a;
        border-radius: 6px;
        color: #e0e0e0;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
    }

    .copies-input:focus {
        outline: none;
        border-color: #4a9eff;
        background: #252525;
    }

    .products-table-wrapper {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #2a2a2a;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #2a2a2a;
    }

    .selected-info {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #b0b0b0;
        font-size: 14px;
    }

    .selected-badge {
        background: #4a9eff;
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
    }

    .empty-state {
        padding: 60px 40px;
        text-align: center;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 18px;
        color: #e0e0e0;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .empty-text {
        color: #6a6a6a;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1 class="dashboard-title">Barcode Printing Dashboard</h1>
    <p class="dashboard-subtitle">Search products and generate barcode labels for your inventory</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Products</div>
        <div class="stat-value" id="totalProducts">-</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Today's Prints</div>
        <div class="stat-value" id="todayPrints">-</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Selected Items</div>
        <div class="stat-value" id="selectedCountValue">0</div>
    </div>
</div>

<div class="search-section">
    <div class="search-header">
        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <h2 class="search-title">Search Products</h2>
    </div>
    
    <div class="form-group enhanced-input" style="position: relative;">
        <svg class="search-input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <input type="search" id="search" placeholder="Type product code or name to search..." autocomplete="off">
        
        <div id="suggestionsDropdown" class="suggestions-dropdown"></div>
    </div>
</div>

<div id="results" class="results-section" style="display: none;">
    <form action="{{ route('barcode.generate') }}" method="POST" id="barcodeForm">
        @csrf
        
        <div class="copies-section">
            <label for="copies" class="copies-label">Number of copies per product:</label>
            <input type="number" name="copies" id="copies" value="1" min="1" max="300" class="copies-input">
            <span style="color: #6a6a6a; font-size: 13px;">(1-300)</span>
        </div>
        
        <div class="products-table-wrapper">
            <table id="productsTable">
                <thead>
                    <tr>
                        <th style="width: 50px; padding: 12px;">
                            <input type="checkbox" id="selectAll" style="cursor: pointer;">
                        </th>
                        <th style="padding: 12px;">Code</th>
                        <th style="padding: 12px;">Product Name</th>
                        <th style="padding: 12px; text-align: right;">Price</th>
                        <th style="padding: 12px; text-align: center;">Stock</th>
                    </tr>
                </thead>
                <tbody id="productsBody">
                </tbody>
            </table>
        </div>

        <div class="action-bar">
            <div class="selected-info">
                <span id="selectedCount">0 products selected</span>
                <span id="selectedBadge" class="selected-badge" style="display: none;"></span>
            </div>
            <button type="submit" class="btn btn-primary" id="generateBtn" disabled>
                <span style="margin-right: 8px;">🖨️</span>
                Generate Barcodes
            </button>
        </div>
    </form>
</div>

<div id="noResults" class="card empty-state" style="display: none;">
    <div class="empty-icon">🔍</div>
    <div class="empty-title">No products found</div>
    <div class="empty-text">Try a different search term or check the spelling</div>
</div>

<div id="initialMessage" class="card empty-state">
    <div class="empty-icon">📦</div>
    <div class="empty-title">Ready to Print Barcodes</div>
    <div class="empty-text">Start typing a product code or name to search</div>
</div>

@push('scripts')
<script>
    let searchTimeout;
    const searchInput = document.getElementById('search');
    const suggestionsDropdown = document.getElementById('suggestionsDropdown');
    const resultsDiv = document.getElementById('results');
    const noResultsDiv = document.getElementById('noResults');
    const initialMessage = document.getElementById('initialMessage');
    const productsBody = document.getElementById('productsBody');
    const selectAllCheckbox = document.getElementById('selectAll');
    const generateBtn = document.getElementById('generateBtn');
    const selectedCount = document.getElementById('selectedCount');
    const selectedCountValue = document.getElementById('selectedCountValue');
    const selectedBadge = document.getElementById('selectedBadge');
    const totalProductsEl = document.getElementById('totalProducts');

    // Load dashboard stats
    fetch('/stats')
        .then(r => r.json())
        .then(stats => {
            totalProductsEl.textContent = stats.total_products || '-';
            document.getElementById('todayPrints').textContent = stats.today_prints || '0';
        })
        .catch(error => {
            console.error('Error loading stats:', error);
        });

    // Auto-suggest functionality
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            suggestionsDropdown.style.display = 'none';
            resultsDiv.style.display = 'none';
            noResultsDiv.style.display = 'none';
            initialMessage.style.display = 'block';
            return;
        }

        searchTimeout = setTimeout(() => {
            showSuggestions(query);
        }, 300);
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target !== searchInput && !suggestionsDropdown.contains(e.target)) {
            suggestionsDropdown.style.display = 'none';
        }
    });

    function showSuggestions(query) {
        fetch(`/search?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(products => {
                if (products.length === 0) {
                    suggestionsDropdown.style.display = 'none';
                    return;
                }

                displaySuggestions(products);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function displaySuggestions(products) {
        suggestionsDropdown.innerHTML = '';
        
        products.forEach(product => {
            const item = document.createElement('div');
            item.style.cssText = `
                padding: 14px 18px;
                cursor: pointer;
                border-bottom: 1px solid #3a3a3a;
                transition: all 0.2s ease;
            `;
            
            item.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: #e0e0e0; margin-bottom: 4px; font-size: 14px;">${product.name}</div>
                        <div style="font-size: 12px; color: #4a9eff; font-family: monospace; letter-spacing: 0.5px;">${product.code}</div>
                    </div>
                    <div style="font-weight: 700; color: #ffffff; font-size: 15px;">Rs ${parseFloat(product.price).toFixed(2)}</div>
                </div>
            `;
            
            item.addEventListener('mouseenter', function() {
                this.style.background = '#2a2a2a';
                this.style.borderLeft = '3px solid #4a9eff';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
                this.style.borderLeft = 'none';
            });
            
            item.addEventListener('click', function() {
                searchProducts([product]);
                suggestionsDropdown.style.display = 'none';
                searchInput.value = product.code + ' - ' + product.name;
            });
            
            suggestionsDropdown.appendChild(item);
        });
        
        suggestionsDropdown.style.display = 'block';
    }

    function searchProducts(products) {
        if (products.length === 0) {
            resultsDiv.style.display = 'none';
            noResultsDiv.style.display = 'block';
            initialMessage.style.display = 'none';
            return;
        }

        displayProducts(products);
        resultsDiv.style.display = 'block';
        noResultsDiv.style.display = 'none';
        initialMessage.style.display = 'none';
    }

    function displayProducts(products) {
        productsBody.innerHTML = '';
        selectAllCheckbox.checked = false;

        products.forEach((product, index) => {
            const row = document.createElement('tr');
            row.style.transition = 'background 0.2s';
            row.innerHTML = `
                <td style="padding: 14px 12px;">
                    <input type="checkbox" name="products[]" value="${product.id}" class="product-checkbox" style="cursor: pointer;">
                </td>
                <td style="padding: 14px 12px; font-family: monospace; color: #4a9eff; font-weight: 600; letter-spacing: 0.5px;">${product.code}</td>
                <td style="padding: 14px 12px; color: #e0e0e0;">${product.name}</td>
                <td style="padding: 14px 12px; text-align: right; font-weight: 600; color: #ffffff;">Rs ${parseFloat(product.price).toFixed(2)}</td>
                <td style="padding: 14px 12px; text-align: center;">
                    <span style="
                        display: inline-block;
                        padding: 4px 10px;
                        border-radius: 12px;
                        font-size: 12px;
                        font-weight: 600;
                        background: ${product.quantity > 0 ? 'rgba(107, 255, 107, 0.15)' : 'rgba(255, 107, 107, 0.15)'};
                        color: ${product.quantity > 0 ? '#6bff6b' : '#ff6b6b'};
                    ">${parseFloat(product.quantity).toFixed(0)}</span>
                </td>
            `;
            
            row.addEventListener('mouseenter', function() {
                this.style.background = '#252525';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
            });
            
            productsBody.appendChild(row);
        });

        updateCheckboxListeners();
        selectedCountValue.textContent = '0';
    }

    function updateCheckboxListeners() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
    }

    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });

    function updateSelectedCount() {
        const selected = document.querySelectorAll('.product-checkbox:checked').length;
        const countText = selected === 0 ? 'No products selected' : `${selected} product${selected !== 1 ? 's' : ''} selected`;
        selectedCount.textContent = countText;
        
        if (selected > 0) {
            selectedBadge.textContent = selected;
            selectedBadge.style.display = 'inline-block';
        } else {
            selectedBadge.style.display = 'none';
        }
        
        selectedCountValue.textContent = selected;
        generateBtn.disabled = selected === 0;
        
        if (selected > 0) {
            generateBtn.style.opacity = '1';
            generateBtn.style.cursor = 'pointer';
        } else {
            generateBtn.style.opacity = '0.5';
            generateBtn.style.cursor = 'not-allowed';
        }
        
        const allCheckboxes = document.querySelectorAll('.product-checkbox');
        const allChecked = selected === allCheckboxes.length && selected > 0;
        selectAllCheckbox.checked = allChecked;
    }
</script>
@endpush
@endsection

