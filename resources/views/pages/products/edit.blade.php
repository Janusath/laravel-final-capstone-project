@extends('layout.app')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Edit Brand</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="students.html">Brands</a></li>
                            <li class="breadcrumb-item active">Edit Brands</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card comman-shadow">
                    <div class="card-body">
                        <form action="{{ route('brands.update',$brand) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Brand Information <span><a href="javascript:;"><i
                                                    class="feather-more-vertical"></i></a></span></h5>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group local-forms">
                                        <label>Brand Name <span class="login-danger">*</span></label>
                                        <input class="form-control" name="brand_name" value="{{ old('brand_name',$brand->brand_name) }}"
                                            type="text" placeholder="Enter Brand Name">
                                             @error('brand_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group local-forms">
                                        <label>Description <span class="login-danger"></span></label>
                                        <textarea class="form-control" name="description">{{ old('description',$brand->description) }}</textarea>
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
