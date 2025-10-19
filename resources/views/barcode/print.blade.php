<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcodes - LAPTOP EXPERT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0 auto; /* Center the content */
            background: #f0f0f0; /* Light background to see paper */
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .barcode-container {
            display: flex;
            flex-wrap: wrap;
            width: 107mm;
            padding: 0;
            margin: 0;
            background: #ffffff; /* White paper background */
        }

        .barcode-row {
            display: flex;
            width: 107mm;
            margin-bottom: 3mm; /* Space between rows */
        }

        .barcode-spacer {
            width: 2mm;
            flex-shrink: 0;
        }

        .barcode-label {
            width: 33mm; /* 3.3cm */
            height: 21mm; /* 2.1cm */
            border: 1px solid #000;
            padding: 1mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            page-break-inside: avoid;
            background: #ffffff;
            flex-shrink: 0;
        }

        .product-name {
            font-size: 6pt;
            font-weight: bold;
            text-align: center;
            color: #000;
            width: 100%;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            line-height: 1.1;
            height: 6mm;
            word-wrap: break-word;
        }

        .product-price {
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
            color: #000;
            margin: 0.5mm 0;
        }

        .barcode-image {
            width: 100%;
            height: auto;
            max-height: 10mm;
            object-fit: contain;
        }

        .product-code {
            font-size: 6pt;
            font-family: 'Courier New', monospace;
            text-align: center;
            color: #000;
            font-weight: bold;
            margin-top: 0.5mm;
        }

        .controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #4a9eff;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #357abd;
        }

        .btn-secondary {
            background: #6a6a6a;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: #4a4a4a;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
                margin: 0;
                display: block;
            }

            .barcode-container {
                width: 107mm;
                margin: 0;
            }

            .controls {
                display: none;
            }

            .barcode-row {
                margin-bottom: 3mm;
            }

            .barcode-label {
                border: 1px solid #000;
            }

            @page {
                size: 107mm auto; /* Continuous roll: 10.7cm width, auto height */
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="barcode-container">
        @php
            $chunks = $products->chunk(3); // 3 barcodes per row
        @endphp

        @foreach($chunks as $chunk)
            <div class="barcode-row">
                <div class="barcode-spacer"></div> <!-- Left 2mm space -->
                
                @foreach($chunk as $index => $product)
                    <div class="barcode-label">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">Rs. {{ number_format($product->price, 2) }}</div>
                        <img src="{{ route('barcode.image', ['code' => $product->code]) }}" alt="Barcode" class="barcode-image">
                        <div class="product-code">{{ $product->code }}</div>
                    </div>
                    
                    <div class="barcode-spacer"></div> <!-- 2mm space after each barcode -->
                @endforeach
                
                @php
                    // Fill remaining slots if less than 3 barcodes in row
                    $remaining = 3 - $chunk->count();
                @endphp
                
                @for($i = 0; $i < $remaining; $i++)
                    <div style="width: 33mm; height: 21mm;"></div> <!-- Empty placeholder -->
                    <div class="barcode-spacer"></div>
                @endfor
            </div>
        @endforeach
    </div>

    <div class="controls">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.location.href='{{ route('barcode.index') }}'" class="btn btn-secondary">Back</button>
    </div>
</body>
</html>

