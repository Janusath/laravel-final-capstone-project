@extends('layout.app')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Edit Customer</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="students.html">Customer</a></li>
                            <li class="breadcrumb-item active">Edit Customer</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="card comman-shadow">
                    <div class="card-body">
                        <form action="{{ route('customers.update',$customer->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Customer Information <span><a href="javascript:;"><i
                                                    class="feather-more-vertical"></i></a></span></h5>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group local-forms">
                                        <label>Customer Name <span class="login-danger">*</span></label>
                                        <input class="form-control" name="customer_name" value="{{ old('customer_name', $customer->customer_name) }}"
                                            type="text" placeholder="Enter Customer Name">
                                        @error('customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group local-forms">
                                        <label>Customer Phone No <span class="login-danger">*</span></label>
                                        <input class="form-control" name="phone_no" value="{{ old('phone_no',$customer->phone_no) }}"
                                            type="text" placeholder="Enter Customer Phone No">
                                        @error('phone_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group local-forms">
                                        <label>Customer Email <span class="login-danger">*</span></label>
                                        <input class="form-control" name="email" value="{{ old('email', $customer->email) }}"
                                            type="email" placeholder="Enter Customer Email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group local-forms">
                                        <label>Address <span class="login-danger"></span></label>
                                        <textarea class="form-control" name="address" placeholder="Enter Address">{{ old('address',$customer->address) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
