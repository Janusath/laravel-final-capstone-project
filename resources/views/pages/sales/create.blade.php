@extends('layout.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Left Panel: Sale Form -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create Sale</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Customer</label>
                            <select class="form-control" name="customer_id" required>
                                <option selected disabled>Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->customer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label>Sale Date</label>
                            <input type="date" class="form-control" name="sale_date"
                                   value="{{ old('sale_date', date('Y-m-d')) }}" required>
                        </div>

                        <table class="table table-bordered" id="saleItemsTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th><button type="button" id="addRowBtn" class="btn btn-sm btn-success"><i class="feather-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="hidden" class="product_id" name="product_id[]" readonly>
                                        <input type="text" class="form-control product_name" readonly>
                                    </td>
                                    <td><input type="number" class="form-control quantity" name="quantity[]" min="1" value="1"></td>
                                    <td><input type="number" class="form-control selling_price" name="selling_price[]"></td>
                                    <td><input type="number" class="form-control discount" name="discount[]" value="0"></td>
                                    <td><input type="number" class="form-control final_price" name="final_price[]" readonly></td>
                                    <td><button type="button" class="btn btn-sm btn-danger removeRowBtn"><i class="feather-trash-2"></i></button></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="form-group">
                            <label>Total</label>
                            <input type="number" class="form-control" id="total" name="total" readonly>
                        </div>

                        <div class="form-group">
                            <label>Final Discount</label>
                            <input type="number" class="form-control" id="final_discount" name="final_discount" value="0">
                        </div>

                        <div class="form-group">
                            <label>Final Total</label>
                            <input type="number" class="form-control" id="final_total_input" name="final_total" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Submit Sale</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Panel: Product Catalog -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Products</h5>
                    <select id="categoryFilter" class="form-select w-auto">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <div class="row" id="productList">
                        @foreach($products as $product)
                        <div class="col-md-4 mb-3 product-box" data-category="{{ $product->category_id }}">
                            <div class="card h-100 text-center">
                                @if($product->product_image)
                                    <img src="{{ asset('storage/' . $product->product_image) }}" class="card-img-top" height="100" alt="">
                                @endif
                                <div class="card-body">
                                    <h6>{{ $product->product_name }}</h6>
                                    <p class="mb-1">Rs. {{ $product->selling_price }}</p>
                                    <button type="button" class="btn btn-sm btn-outline-primary addToSaleBtn"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->product_name }}"
                                        data-price="{{ $product->selling_price }}">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    $(document).ready(function() {
        // Add product from catalog
        $('.addToSaleBtn').click(function() {
            let name = $(this).data('name');
            let price = $(this).data('price');
            let id = $(this).data('id');

            let newRow = $('#saleItemsTable tbody tr:first').clone();
            newRow.find('input').val('');
            newRow.find('.product_id').val(id);
            newRow.find('.product_name').val(name);
            newRow.find('.selling_price').val(price);
            newRow.find('.quantity').val(1);
            newRow.find('.discount').val(0);
            newRow.find('.final_price').val(price);
            $('#saleItemsTable tbody').append(newRow);
            calculateTotals();
        });

        // Add empty row
        $('#addRowBtn').click(function() {
            let newRow = $('#saleItemsTable tbody tr:first').clone();
            newRow.find('input').val('');
            $('#saleItemsTable tbody').append(newRow);
        });

        // Remove row
        $(document).on('click', '.removeRowBtn', function() {
            if ($('#saleItemsTable tbody tr').length > 1) {
                $(this).closest('tr').remove();
                calculateTotals();
            }
        });

        // Auto calculate totals
        $(document).on('input', '.quantity, .selling_price, .discount, #final_discount', function() {
            calculateTotals();
        });

        // Filter by category
        $('#categoryFilter').change(function() {
            let selected = $(this).val();
            $('.product-box').each(function() {
                let cat = $(this).data('category');
                $(this).toggle(selected === "" || cat == selected);
            });
        });

        function calculateTotals() {
            let total = 0;
            $('#saleItemsTable tbody tr').each(function() {
                let qty = parseFloat($(this).find('.quantity').val()) || 0;
                let price = parseFloat($(this).find('.selling_price').val()) || 0;
                let discount = parseFloat($(this).find('.discount').val()) || 0;
                let rowTotal = (qty * price) - discount;
                $(this).find('.final_price').val(rowTotal.toFixed(2));
                total += rowTotal;
            });
            $('#total').val(total.toFixed(2));
            let finalDiscount = parseFloat($('#final_discount').val()) || 0;
            $('#final_total_input').val((total - finalDiscount).toFixed(2));
        }
    });
</script>
@endsection
