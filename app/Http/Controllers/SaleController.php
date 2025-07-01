<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Show the form for creating a new sale.
     */
public function create()
{
    $products = Product::all();
    $categories = Category::all();
    $customers = Customer::all();

    return view('pages.sales.create', compact('products', 'categories', 'customers'));
}

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'     => 'required|exists:customers,id',
            'sale_date'       => 'required|date',
            'total'           => 'required|numeric|min:0',
            'final_discount'  => 'required|numeric|min:0',
            'final_total'     => 'required|numeric|min:0',
            'product_id.*'    => 'required|exists:products,id',
            'quantity.*'      => 'required|numeric|min:1',
            'discount.*'      => 'required|numeric|min:0',
            'selling_price.*' => 'required|numeric|min:0',
            'final_price.*'   => 'required|numeric|min:0',
        ]);

        // Generate invoice number
        $lastSale = Sale::orderBy('id', 'desc')->first();
        $lastNumber = $lastSale ? (int) str_replace('INV', '', $lastSale->invoice_number) : 0;
        $invoice_number = 'INV' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        DB::beginTransaction();

        try {
            // Check stock for each product
            foreach ($request->product_id as $index => $productId) {
                $saleQuantity = $request->quantity[$index];
                $product = Product::find($productId);
                $currentStock = InventoryTracker::where('product_id', $productId)->sum('quantity');

                if ($currentStock < $saleQuantity) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', "Insufficient stock for {$product->product_name}. Available: {$currentStock}, Requested: {$saleQuantity}")
                        ->withInput();
                }
            }

            // Create sale
            $sale = Sale::create([
                'customer_id'    => $request->customer_id,
                'sale_date'      => $request->sale_date,
                'total'          => $request->total,
                'final_discount' => $request->final_discount,
                'final_total'    => $request->final_total,
                'invoice_number' => $invoice_number,
            ]);

            // Create sale items
            foreach ($request->product_id as $index => $productId) {
                SaleItem::create([
                    'sale_id'       => $sale->id,
                    'product_id'    => $productId,
                    'quantity'      => $request->quantity[$index],
                    'discount'      => $request->discount[$index],
                    'selling_price' => $request->selling_price[$index],
                    'final_price'   => $request->final_price[$index],
                ]);

                // Update stock in Inventory Tracker
                InventoryTracker::create([
                    'product_id'     => $productId,
                    'quantity'       => -1 * $request->quantity[$index],
                    'inventory_type' => 'sale',
                ]);
            }

            DB::commit();
            return redirect()->route('sales.create')->with('success', 'Sale created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Placeholder methods
    public function index() {}
    public function show(Sale $sale) {}
    public function edit(Sale $sale) {}
    public function update(Request $request, Sale $sale) {}
    public function destroy(Sale $sale) {}
}
