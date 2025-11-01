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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            padding: 0;
            margin: 0 auto;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding-top: 20px;
        }

        .barcode-container {
            display: flex;
            flex-wrap: wrap;
            width: 107mm;
            padding: 0;
            margin: 0;
            background: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .barcode-row {
            display: flex;
            width: 107mm;
            margin-bottom: 3mm; /* Space between rows */
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .barcode-spacer {
            width: 2mm;
            flex-shrink: 0;
        }

        .barcode-label {
            width: 33mm; /* 3.3cm */
            height: 21mm; /* 2.1cm */
            border: none;
            padding: 1.5mm 2mm; /* Vertical padding slightly less, horizontal more */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            page-break-inside: avoid;
            break-inside: avoid;
            background: #ffffff;
            flex-shrink: 0;
            position: relative;
        }

        .product-name {
            font-size: 6.5pt;
            font-weight: 700;
            text-align: center;
            color: #1a1a1a;
            width: 100%;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 1.15;
            word-wrap: break-word;
            letter-spacing: 0.01em;
            margin-bottom: 0.5mm;
        }

        .product-price {
            font-size: 8.5pt;
            font-weight: 700;
            text-align: center;
            color: #000;
            letter-spacing: 0.05em;
            margin: 0.3mm 0;
            line-height: 1.2;
        }

        .barcode-image {
            width: 100%;
            height: auto;
            max-height: 9mm;
            object-fit: contain;
            image-rendering: crisp-edges;
            margin: 0.5mm 0;
        }

        .product-code {
            font-size: 7pt;
            font-family: 'Courier New', 'Consolas', monospace;
            text-align: center;
            color: #333;
            font-weight: 600;
            letter-spacing: 0.1em;
            line-height: 1.3;
            margin-top: 0.3mm;
        }

        .controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 12px;
            z-index: 1000;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a9eff 0%, #357abd 100%);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #357abd 0%, #2a5a8a 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(74, 158, 255, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6a6a6a 0%, #4a4a4a 100%);
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4a4a4a 0%, #333 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body {
                background: #ffffff;
                padding: 0 !important;
                margin: 0 !important;
                display: block;
                width: 107mm;
            }

            .barcode-container {
                width: 107mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff;
                box-shadow: none;
            }

            .controls {
                display: none !important;
            }

            .barcode-row {
                margin-bottom: 3mm;
                page-break-inside: avoid;
                break-inside: avoid;
            }

            .barcode-label {
                border: none;
                page-break-inside: avoid;
                break-inside: avoid;
            }

            @page {
                size: 107mm auto; /* Continuous roll: 10.7cm width, auto height */
                margin: 0;
                padding: 0;
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
                        <div class="product-price">Rs {{ number_format($product->price, 2) }}</div>
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
        <div style="background: #fff; padding: 12px 16px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); margin-right: 12px; font-size: 12px; color: #666; max-width: 200px;">
            <strong>Print Tips:</strong><br>
            • Set paper size to Custom: 107mm<br>
            • Set margins to None/Minimal<br>
            • Disable headers/footers<br>
            • Scale: 100%
        </div>
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.location.href='{{ route('barcode.index') }}'" class="btn btn-secondary">Back</button>
    </div>
</body>
</html>

