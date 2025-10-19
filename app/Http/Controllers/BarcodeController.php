<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BarcodePrintLog;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeController extends Controller
{
    public function index()
    {
        return view('barcode.index');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $products = Product::where('code', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->limit(50)
            ->get(['id', 'code', 'name', 'price', 'quantity']);
        
        return response()->json($products);
    }

    public function generate(Request $request)
    {
        $productIds = $request->input('products', []);
        $copies = max(1, min(300, (int)$request->input('copies', 1)));
        
        if (empty($productIds)) {
            return redirect()->back()->with('error', 'Please select at least one product');
        }

        $products = Product::whereIn('id', $productIds)->get();
        
        // Log each product print
        foreach ($products as $product) {
            BarcodePrintLog::create([
                'product_id' => $product->id,
                'product_code' => $product->code,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'copies_printed' => $copies,
                'printed_at' => now(),
                'printed_by' => auth()->user()->name,
            ]);
        }
        
        // Duplicate products based on number of copies
        $duplicatedProducts = collect();
        foreach ($products as $product) {
            for ($i = 0; $i < $copies; $i++) {
                $duplicatedProducts->push($product);
            }
        }
        
        $products = $duplicatedProducts;
        
        return view('barcode.print', compact('products'));
    }
    
    public function reports(Request $request)
    {
        $query = BarcodePrintLog::query()->orderBy('printed_at', 'desc');
        
        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('printed_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('printed_at', '<=', $request->end_date);
        }
        
        // Filter by product code
        if ($request->has('product_code') && $request->product_code) {
            $query->where('product_code', 'LIKE', '%' . $request->product_code . '%');
        }
        
        $logs = $query->paginate(50);
        
        // Summary statistics
        $totalPrints = BarcodePrintLog::sum('copies_printed');
        $uniqueProducts = BarcodePrintLog::distinct('product_id')->count();
        $todayPrints = BarcodePrintLog::whereDate('printed_at', today())->sum('copies_printed');
        
        return view('barcode.reports', compact('logs', 'totalPrints', 'uniqueProducts', 'todayPrints'));
    }
    
    public function exportReports(Request $request)
    {
        $query = BarcodePrintLog::query()->orderBy('printed_at', 'desc');
        
        // Apply same filters
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('printed_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('printed_at', '<=', $request->end_date);
        }
        
        if ($request->has('product_code') && $request->product_code) {
            $query->where('product_code', 'LIKE', '%' . $request->product_code . '%');
        }
        
        $logs = $query->get();
        
        $filename = 'barcode_print_logs_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['Date & Time', 'Product Code', 'Product Name', 'Price', 'Copies Printed', 'Printed By']);
            
            // Add data rows
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->printed_at->format('Y-m-d H:i:s'),
                    $log->product_code,
                    $log->product_name,
                    number_format($log->product_price, 2),
                    $log->copies_printed,
                    $log->printed_by,
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function generateBarcode($code)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128, 3, 50);
        
        return response($barcode)->header('Content-Type', 'image/png');
    }
}
