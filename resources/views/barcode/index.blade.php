@extends('layouts.app')

@section('title', 'Search Products - LAPTOP EXPERT Barcode Printing System')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 20px; color: #ffffff; font-size: 20px;">Search Products</h2>
    
    <div class="form-group" style="position: relative;">
        <label for="search">Search by Product Code or Name</label>
        <input type="search" id="search" placeholder="Enter product code or name..." autocomplete="off">
        
        <!-- Auto-suggest dropdown -->
        <div id="suggestionsDropdown" style="
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #2a2a2a;
            border: 1px solid #4a9eff;
            border-top: none;
            border-radius: 0 0 6px 6px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        "></div>
    </div>

    <div id="results" style="display: none;">
        <form action="{{ route('barcode.generate') }}" method="POST" id="barcodeForm">
            @csrf
            
            <div style="margin-bottom: 20px; padding: 15px; background: #2a2a2a; border-radius: 6px; border: 1px solid #3a3a3a;">
                <label for="copies" style="margin-bottom: 8px; display: block;">Number of copies per product (1-300):</label>
                <input type="number" name="copies" id="copies" value="1" min="1" max="300" 
                    style="width: 120px; padding: 8px 12px; background: #1e1e1e; border: 1px solid #3a3a3a; border-radius: 6px; color: #e0e0e0;">
            </div>
            
            <table id="productsTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody id="productsBody">
                </tbody>
            </table>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" id="generateBtn" disabled>
                    Generate Barcodes
                </button>
                <span id="selectedCount" style="line-height: 40px; color: #b0b0b0;">0 products selected</span>
            </div>
        </form>
    </div>

    <div id="noResults" style="display: none; padding: 40px; text-align: center; color: #6a6a6a;">
        No products found. Try a different search term.
    </div>

    <div id="initialMessage" style="padding: 40px; text-align: center; color: #6a6a6a;">
        Enter a product code or name to search
    </div>
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
                padding: 12px 16px;
                cursor: pointer;
                border-bottom: 1px solid #3a3a3a;
                transition: background 0.2s;
            `;
            
            item.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: #e0e0e0; margin-bottom: 2px;">${product.name}</div>
                        <div style="font-size: 12px; color: #4a9eff; font-family: monospace;">${product.code}</div>
                    </div>
                    <div style="font-weight: 600; color: #e0e0e0;">Rs. ${parseFloat(product.price).toFixed(2)}</div>
                </div>
            `;
            
            item.addEventListener('mouseenter', function() {
                this.style.background = '#3a3a3a';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
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

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <input type="checkbox" name="products[]" value="${product.id}" class="product-checkbox">
                </td>
                <td style="font-family: monospace; color: #4a9eff;">${product.code}</td>
                <td>${product.name}</td>
                <td style="font-weight: 600;">Rs. ${parseFloat(product.price).toFixed(2)}</td>
                <td style="color: ${product.quantity > 0 ? '#6bff6b' : '#ff6b6b'};">${parseFloat(product.quantity).toFixed(0)}</td>
            `;
            productsBody.appendChild(row);
        });

        updateCheckboxListeners();
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
        selectedCount.textContent = `${selected} product${selected !== 1 ? 's' : ''} selected`;
        generateBtn.disabled = selected === 0;
        
        const allCheckboxes = document.querySelectorAll('.product-checkbox');
        const allChecked = selected === allCheckboxes.length && selected > 0;
        selectAllCheckbox.checked = allChecked;
    }
</script>
@endpush
@endsection

