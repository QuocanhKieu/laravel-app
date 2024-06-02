@extends('admin.layouts.admin')
@section('title', )
<title>Edit {{$brand->name}} Brand </title>
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
        .logo {
            width: 130px;
            min-height: 50px;
        }
        .banner {
            width: 100%;
            max-width: 800px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header',['name' => 'Brands', 'key' => 'Edit','url' => route('brands')])
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Edit This Brand</h5>
                                <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" style="clear: both">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group">
                                        <label for="catName">Brand Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="catName" aria-describedby="catName"
                                               placeholder="Enter Brand Name" name="name" value="{{old('name',$brand->name)}}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="logo">Brand Logo</label><br>
                                        <img src="{{ asset("$brand->logo_path")  }}" class="logo" alt="Logo Image">
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                               id="logo" name="logo" accept="image/*" value="{{old('logo',$brand->logo)}}" >
                                        @error('logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="banner">Brand Banner</label><br>
                                        <img src="{{ asset("$brand->banner_path")  }}" class="banner" alt="banner Image">

                                        <input type="file" class="form-control @error('banner') is-invalid @enderror"
                                               id="banner" name="banner" accept="image/*" value="{{old('banner',$brand->banner)}}">
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
                tags: false,
                tokenSeparators: [','],
                placeholder: 'Danh Mục cho Brand',
                allowClear: true
            });
        });
    </script>
@endsection






