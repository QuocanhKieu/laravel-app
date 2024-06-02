@extends('admin.layouts.admin')



@section('title')
    <title>Danh Sách Categories</title>
@endsection
@section('this-css')
    <style>
        .logo {
            max-width: 135px;
            height: 80px;
            object-fit: cover;
        }
        .banner {
            max-width: 230px;
            height: 80px;
            object-fit: cover;
        }
        .table td, .table th {
            vertical-align: middle;
        }

    </style>
@endsection
@section('content')
        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header',['name' => '', 'key' => 'Categories','url' => ''])

        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="row col-md-12">
                        <div class="col-12" style="display: flex; justify-content: end;">
                            <a href="{{route('categories.create')}}" class="btn btn-primary m-2">ADD</a>
                        </div>
                    </div>
                    <div class="div col-md-12">
                        <div id="categoryTable">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Parent_id</th>
                                    <th scope="col">logo</th>
                                    <th scope="col">Banner</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <th scope="row">{{$category->id}}</th>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->parent_id}}</td>
                                        <td>
                                            <img src="{{asset("$category->logo_path")}}" class="logo" alt="Logo Image">
                                        </td>
                                        <td>
                                            <img src="{{asset("$category->banner_path")}}" class="banner" alt="Banner Image">
                                        </td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                               class="btn btn-primary">Edit</a>
                                            @if($category->deleted_at)
                                                <button type="button" class="btn btn-success"
                                                        onclick="toggleDeletedCategories(this, {{ $category->id}})"
                                                        id="restoreBtn"> Restore
                                                </button>
                                            @else
                                                <a href="{{ route('categories.delete', $category->id) }}"
                                                   class="btn btn-danger"
                                                   onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="col-md-12">
                                {{ $categories->links('vendor.pagination.bootstrap-4') }}
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
    <script type="text/javascript">
        function toggleDeletedCategories(button, id) {
            console.log($(button));
            console.log(`enter function id ${id}`)
            var restoreBtn = document.getElementById('restoreBtn');
            // Send an AJAX request to fetch categories based on showDeleted value
            $.ajax({
                url: "{{ route('categories.restore') }}",
                type: "put",
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    var deleteLink = $('<a>', {
                        href: "{{ route('categories.delete', ':id') }}".replace(':id', id),
                        class: 'btn btn-danger',
                        onclick: "return confirm('Are you sure you want to delete this category?')",
                        text: 'Delete'

                    });
                    $(button).replaceWith(deleteLink);

                    // var htmlContent = response.html;
                    // console.log(htmlContent)
                    // // Update the categoryTable element with the new HTML content
                    // $('#categoryTable').html(htmlContent);
                    // // Update HTML content with new categories data
                }
            });
        }

        (function ($) {
            $(window).on('load', function () {
                console.log('hello');


            });
        })(jQuery);
    </script>
@endsection





