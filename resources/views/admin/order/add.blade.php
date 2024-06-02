@extends('admin.layouts.admin')

@section('title')
<title>Add a New Category</title>
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
        @include('partials.content-header',['name' => 'Categories', 'key' => 'Add','url' => route('categories')])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="div col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add a New Category</h5><br>
                                <form action='{{route('categories.store')}}' method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="catName">Category Name</label>
                                        <input type="text" class="form-control" id="catName" aria-describedby="catName"
                                               placeholder="Enter catName" name="name">
                                        {{--                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
                                    </div>
                                    <div class="form-group">
                                        <label for="logo">Category Logo</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                               id="logo" name="logo" >
                                        @error('logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="banner">Category Banner</label>
                                        <input type="file" class="form-control @error('banner') is-invalid @enderror"
                                               id="banner" name="banner" >
                                        @error('banner')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="parentCat">Select Parent Category</label>
                                        <select class="form-control parent_select2" id="parentCat" multiple="multiple" name="parent_id">
                                            <option value="0">Chọn là danh mục cha</option>
                                            {!! $options !!}
                                        </select>
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
            $('.parent_select2').select2({
                tags: false, // Disable creating new tags
                tokenSeparators: [','],
                placeholder: 'Chọn Danh Mục Cha',
                allowClear: true,
                maximumSelectionLength: 1,
            });
        });
    </script>
@endsection





