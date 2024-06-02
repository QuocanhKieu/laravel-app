@extends('admin.layouts.admin')
@section('title')
    <title>Add a New Brand</title>
@endsection
@section('this-css')
    <link rel="stylesheet" href="{{asset('admins/css/select2.min.css')}}">
    <style>
        .select2 {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
             height: auto;
        }
        .select2-selection__choice {
            background-color: #3b3b3b !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header',['name' => 'Brands', 'key' => 'Add','url' => route('brands')])
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add a New Brand</h5><br>
                                <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="catName">Brand Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="catName" aria-describedby="catName"
                                               placeholder="Enter Brand Name" name="name" value="{{old('name')}}" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="logo">Brand Logo</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                               id="logo" name="logo" accept="image/*" value="{{old('logo')}}" required>
                                        @error('logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="banner">Brand Banner</label>
                                        <input type="file" class="form-control @error('banner') is-invalid @enderror"
                                               id="banner" name="banner" accept="image/*" value="{{old('banner')}}" required>
                                        @error('banner')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="select">Chọn Categories cho Brand</label><br>
                                        <select class="categories_select2 form-control @error('categories_id') is-invalid @enderror" multiple="multiple" id="select" name="categories_id[]" required>
                                            {!! $options !!}
                                        </select>
                                        @error('categories_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('this-js')
    <script src="{{asset('admins/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.categories_select2').select2({
                tags: false, // Disable creating new tags
                tokenSeparators: [','],
                placeholder: 'Danh Mục cho Brand',
                allowClear: true
            });
        });
    </script>
@endsection
