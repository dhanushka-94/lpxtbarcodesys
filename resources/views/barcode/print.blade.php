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
            padding: 30px 50px;
        }

        .barcode-container {
            display: flex;
            flex-direction: column;
            width: 107mm;
            padding: 0;
            margin: 0;
            background: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            height: auto;
            min-height: auto;
            position: relative;
            border-left: 1px dashed #ccc;
            border-right: 1px dashed #ccc;
        }

        .measurement-label {
            position: absolute;
            font-size: 8px;
            color: #999;
            background: rgba(255, 255, 255, 0.8);
            padding: 1px 3px;
            border-radius: 2px;
            font-family: monospace;
            z-index: 10;
            pointer-events: none;
        }

        .top-label {
            top: -15px;
            left: 0;
        }

        .left-label {
            left: -30px;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            transform-origin: center;
        }

        .barcode-row {
            display: flex;
            width: 107mm;
            margin-bottom: 3mm;
            page-break-inside: avoid;
            break-inside: avoid;
            position: relative;
            border-top: 1px dashed #ddd;
        }

        .barcode-row:first-child {
            border-top: 2px solid #999;
        }

        .barcode-spacer {
            width: 3mm;
            flex-shrink: 0;
            position: relative;
            border-left: 1px dashed #e0e0e0;
        }

        .barcode-spacer:first-child {
            border-left: 2px solid #999;
        }

        .barcode-label {
            width: 31.67mm;
            height: 21mm;
            border: 1px solid #ccc;
            padding: 1.5mm 2mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            page-break-inside: avoid;
            break-inside: avoid;
            background: #ffffff;
            flex-shrink: 0;
            position: relative;
            margin: 0;
            box-sizing: border-box;
        }

        .barcode-label::before {
            content: '31.67mm';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 7px;
            color: #666;
            background: #fff;
            padding: 0 2px;
            font-family: monospace;
            white-space: nowrap;
        }

        .barcode-label::after {
            content: '21mm';
            position: absolute;
            left: -20px;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            font-size: 7px;
            color: #666;
            background: #fff;
            padding: 0 2px;
            font-family: monospace;
            white-space: nowrap;
        }

        .product-name {
            font-size: 6.5pt;
            font-weight: 400;
            text-align: center;
            color: #1a1a1a;
            width: 100%;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 1.25;
            word-wrap: break-word;
            letter-spacing: 0.01em;
            margin-bottom: 0.5mm;
            min-height: 5mm;
            padding: 0.2mm 0;
            box-sizing: border-box;
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

            html, body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
                width: 107mm !important;
                height: auto !important;
                overflow: visible !important;
            }

            .barcode-container {
                width: 107mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                box-shadow: none !important;
                height: auto !important;
                min-height: auto !important;
                max-height: none !important;
                overflow: visible !important;
                page-break-after: auto !important;
                border: none !important;
            }

            .barcode-label {
                border: none !important;
            }

            .barcode-label::before,
            .barcode-label::after {
                display: none !important;
            }

            .barcode-row {
                border-top: none !important;
            }

            .barcode-spacer {
                border-left: none !important;
            }

            .measurement-label {
                display: none !important;
            }

            .controls {
                display: none !important;
            }

            .barcode-row {
                margin-bottom: 3mm !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-after: auto !important;
                display: flex !important;
                width: 107mm !important;
            }

            .barcode-label {
                border: none !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                height: 21mm !important;
            }

            @page {
                size: 107mm auto; /* Continuous roll: 10.7cm width, auto height */
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="barcode-container">
        <div class="measurement-label top-label" style="width: 107mm; text-align: center;">
            107mm Total Width (Paper Roll)
        </div>
        
        @php
            $chunks = $products->chunk(3); // 3 barcodes per row
        @endphp

        @foreach($chunks as $rowIndex => $chunk)
            <div class="barcode-row">
                <div class="measurement-label left-label" style="display: {{ $rowIndex === 0 ? 'block' : 'none' }};">
                    3mm Margin
                </div>
                
                <div class="barcode-spacer">
                    <span class="measurement-label" style="top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 6px;">3mm</span>
                </div>
                
                @foreach($chunk as $index => $product)
                    <div class="barcode-label">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">Rs {{ number_format($product->price, 2) }}</div>
                        <img src="{{ route('barcode.image', ['code' => $product->code]) }}" alt="Barcode" class="barcode-image">
                        <div class="product-code">{{ $product->code }}</div>
                    </div>
                    
                    <div class="barcode-spacer">
                        <span class="measurement-label" style="top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 6px;">3mm</span>
                    </div>
                @endforeach
                
                @php
                    $remaining = 3 - $chunk->count();
                @endphp
                
                @for($i = 0; $i < $remaining; $i++)
                    <div style="width: 31.67mm; height: 21mm; border: 1px dashed #ddd; box-sizing: border-box;"></div>
                    <div class="barcode-spacer">
                        <span class="measurement-label" style="top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 6px;">3mm</span>
                    </div>
                @endfor
                
                @if($rowIndex < $chunks->count() - 1)
                    <div style="position: absolute; bottom: -1.5mm; left: 0; right: 0; text-align: center; font-size: 6px; color: #999; font-family: monospace;">
                        3mm Gap
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="controls">
        <div style="background: #fff; padding: 12px 16px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); margin-right: 12px; font-size: 12px; color: #666; max-width: 220px;">
            <strong>⚠️ Print All Labels:</strong><br>
            • <strong>Paper Size:</strong> Custom 107mm<br>
            • <strong>More Settings:</strong> Uncheck "Simplify page"<br>
            • <strong>Scale:</strong> 100% (NOT "Fit to page")<br>
            • <strong>Margins:</strong> None<br>
            • <strong>Headers/Footers:</strong> Off<br>
            • <strong>Background:</strong> On (if needed)
        </div>
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.location.href='{{ route('barcode.index') }}'" class="btn btn-secondary">Back</button>
    </div>
</body>
</html>

