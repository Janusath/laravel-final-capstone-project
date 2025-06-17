<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $values = Supplier::all();
       return view('pages.suppliers.index', compact('values'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return view('pages.suppliers.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         $request->validate([
            'supplier_name' => 'required|string',
            'phone_no' => 'required|string',
            'email' => 'required|string|unique:suppliers,email',
            'address' => 'nullable|string|max:255',
        ]);

          Supplier::create([
            'supplier_name' => $request->supplier_name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {

        return view('pages.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'supplier_name' => 'required|string',
            'phone_no' => 'required|string',
            'email' => 'required|string|unique:suppliers,email,' . $supplier->id,
            'address' => 'nullable|string|max:255',
        ]);

        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
