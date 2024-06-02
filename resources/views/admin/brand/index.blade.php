@extends('admin.layouts.admin')
@section('title')
    <title>Danh Sách Brands</title>
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
        @include('admin.partials.content-header',['name' => '', 'key' => 'Brands','url' => ''])

        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="row col-md-12">
                        <div class="col-12" style="display: flex; justify-content: end;">
                            <a href="{{route('brands.create')}}" class="btn btn-primary m-2">Add</a>
                        </div>
                    </div>

                    <div class="div col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <th scope="row">{{ $brand->id }}</th>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <img src="{{ asset("$brand->logo_path")  }}" class="logo" alt="Logo Image">
                                    </td>
                                    <td>
                                        <img src="{{ asset("$brand->banner_path")  }}" class="banner"
                                             alt="Banner Image">
                                    </td>
                                    <td>
                                        <a href="{{ route('brands.edit', $brand->id) }}"
                                           class="btn btn-primary">Edit</a>
                                        @if($brand->deleted_at)
                                            <button type="button" class="btn btn-success"
                                                    onclick="toggleDeleted(this, {{ $brand->id}})"
                                                    id="restoreBtn"
                                                    data-url="{{ route('brands.restore', $brand->id) }}"> Restore
                                            </button>
                                        @else
                                            <a href="{{ route('brands.delete', $brand->id) }}"
                                               class="btn btn-danger"
                                               onclick="return confirm('Are you sure you want to delete this Brand?')">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            {{ $brands->links('vendor.pagination.bootstrap-4') }}
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
    <script type="text/javascript">
        function toggleDeleted(theButton, id) {
            console.log(theButton.dataset.url);
            console.log(`enter function id ${id}`)
            var restoreBtn = document.getElementById('restoreBtn');
            // Send an AJAX request to fetch categories based on showDeleted value
            $.ajax({
                url: theButton.dataset.url,
                type: "put",
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.message && response.message === 'Brand not found.') {
                        // Display an alert to the user indicating the brand was not found
                        alert('Brand not found.');
                    } else {
                        // If the brand was found or if the response does not contain a message,
                        // proceed with replacing the button
                        var deleteLink = $('<a>', {
                            href: "{{ route('brands.delete', ':id') }}".replace(':id', id),
                            class: 'btn btn-danger',
                            onclick: "return confirm('Are you sure you want to delete this Brand?')",
                            text: 'Delete'
                        });
                        $(theButton).replaceWith(deleteLink);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any AJAX errors here
                    console.error('AJAX Error:', error);
                }

            });

        }

        document.addEventListener("DOMContentLoaded", function () {
        });
        document.addEventListener("DOMContentLoaded", function () {
            $('.categories_select2').select2({
                tags: false,
                tokenSeparators: [','], // Corrected option name
                placeholder: 'Danh Mục của Brand',
                allowClear: true
            });
        });


        (function ($) {
            $(window).on('load', function () {
                console.log('hello');


            });
        })(jQuery);
    </script>
@endsection





