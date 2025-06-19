@extends('layout.app')
@section('content')
    <div class="content container-fluid">

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    toastr.success('{{ session('success') }}', 'Success');
                });
            </script>
        @endif


        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Customer Records</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customer Records</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-2">Customer Records</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Customer Phone No</th>
                                        <th>Customer Email</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>


                                </thead>
                                @foreach ($values as $customer)
                                    <tbody>
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>{{ $customer->customer_name }}</td>
                                            <td>{{ $customer->phone_no }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->address ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Edit</a>
                                                <form id="deleteRecord-{{ $customer->id }}" action="{{ route('customers.destroy', $customer) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $customer->id}})" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
               document.getElementById('deleteRecord-'+id).submit();
            }
            });
        }
    </script>

@endsection
