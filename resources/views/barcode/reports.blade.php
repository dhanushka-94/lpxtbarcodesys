@extends('layouts.app')

@section('title', 'Print Reports - LAPTOP EXPERT Barcode Printing System')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('barcode.index') }}" style="color: #4a9eff; text-decoration: none; font-size: 14px;">
        ← Back to Search
    </a>
</div>

<div class="card">
    <h2 style="margin-bottom: 20px; color: #ffffff; font-size: 20px;">Barcode Print Reports</h2>
    
    <!-- Summary Statistics -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: #2a2a2a; padding: 20px; border-radius: 6px; border: 1px solid #3a3a3a;">
            <div style="font-size: 12px; color: #b0b0b0; margin-bottom: 8px;">Total Barcodes Printed</div>
            <div style="font-size: 28px; font-weight: 600; color: #4a9eff;">{{ number_format($totalPrints) }}</div>
        </div>
        <div style="background: #2a2a2a; padding: 20px; border-radius: 6px; border: 1px solid #3a3a3a;">
            <div style="font-size: 12px; color: #b0b0b0; margin-bottom: 8px;">Unique Products</div>
            <div style="font-size: 28px; font-weight: 600; color: #4a9eff;">{{ number_format($uniqueProducts) }}</div>
        </div>
        <div style="background: #2a2a2a; padding: 20px; border-radius: 6px; border: 1px solid #3a3a3a;">
            <div style="font-size: 12px; color: #b0b0b0; margin-bottom: 8px;">Printed Today</div>
            <div style="font-size: 28px; font-weight: 600; color: #4a9eff;">{{ number_format($todayPrints) }}</div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('barcode.reports') }}" id="filterForm" style="margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 15px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="product_code">Product Code</label>
                <input type="text" name="product_code" id="product_code" value="{{ request('product_code') }}" placeholder="Search by code...">
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('barcode.reports') }}" class="btn" style="background: #3a3a3a; color: #e0e0e0; text-decoration: none; display: inline-block;">Clear</a>
            </div>
        </div>
    </form>

    <!-- Export Button -->
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('barcode.reports.export', request()->all()) }}" class="btn" style="background: #2a7a2a; color: #ffffff; text-decoration: none; display: inline-block;">
            📊 Export to CSV
        </a>
    </div>

    <!-- Reports Table -->
    @if($logs->count() > 0)
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Copies</th>
                    <th>Printed By</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td style="white-space: nowrap;">{{ $log->printed_at->format('Y-m-d H:i:s') }}</td>
                    <td style="font-family: monospace; color: #4a9eff;">{{ $log->product_code }}</td>
                    <td>{{ $log->product_name }}</td>
                    <td style="font-weight: 600;">Rs. {{ number_format($log->product_price, 2) }}</td>
                    <td style="text-align: center; font-weight: 600; color: #4a9eff;">{{ $log->copies_printed }}</td>
                    <td style="color: #b0b0b0;">{{ $log->printed_by }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 30px;">
        {{ $logs->links('pagination::simple-default') }}
    </div>
    @else
    <div style="padding: 40px; text-align: center; color: #6a6a6a;">
        No print logs found for the selected filters.
    </div>
    @endif
</div>

@push('styles')
<style>
    input[type="date"] {
        width: 100%;
        padding: 12px 16px;
        background: #2a2a2a;
        border: 1px solid #3a3a3a;
        border-radius: 6px;
        color: #e0e0e0;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    input[type="date"]:focus {
        outline: none;
        border-color: #4a9eff;
    }

    /* Pagination styles */
    nav[role="navigation"] {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    nav[role="navigation"] a,
    nav[role="navigation"] span {
        padding: 8px 16px;
        background: #2a2a2a;
        border: 1px solid #3a3a3a;
        border-radius: 6px;
        color: #e0e0e0;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
    }

    nav[role="navigation"] a:hover {
        background: #3a3a3a;
        border-color: #4a9eff;
    }

    nav[role="navigation"] span {
        color: #6a6a6a;
    }
</style>
@endpush
@endsection

