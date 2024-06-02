@extends('admin.layouts.admin')

@section('title')
    <title>Danh Sách Sản Phẩm</title>
@endsection
@section('this-css')
    <style>
        img {
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
        @include('admin.partials.content-header',['name' => '', 'key' => 'Danh Sách Sản Phẩm','url' => ''])

        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="display: flex; justify-content: end;">
                        <a href="{{route('products.create')}}" class="btn btn-primary m-2">Create Product</a>
                    </div>
                    <div class="div col-md-12">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Sale Price</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Feature Image</th>
                                        <th scope="col">Creator</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Total Quantity</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">{{ $product->id }}</th>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->sale_price }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>
                                                <img src="{{asset($product->feature_image_path)}}" alt="Feature Image">
                                            </td>
                                            <td>{{ 'ID: '.$product->user_id.'-'.$product->user->name  }}</td>
                                            <td>{{ $product->brand->name}}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <!-- Accessing the name of the category -->
                                            <td>
                                                {{ $product->total_quantity }}
                                            </td>
{{--                                            <td>--}}
{{--                                                <a href="{{ route('products.edit', $product->id) }}"--}}
{{--                                                   class="btn btn-primary">Edit</a>--}}
{{--                                                <a href="{{ route('products.delete', $product->id) }}"--}}
{{--                                                   class="btn btn-danger"--}}
{{--                                                   onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>--}}
{{--                                            </td>--}}
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                   class="btn btn-primary">Edit</a>
                                                @if($product->deleted_at)
                                                    <button type="button" class="btn btn-success"
                                                            onclick="toggleDeletedProduct(this, {{ $product->id}})"
                                                            id="restoreBtn"> Restore
                                                    </button>
                                                @else
                                                    <a href="{{ route('products.delete', $product->id) }}"
                                                       class="btn btn-danger"
                                                       onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                        <div class="col-md-12">
                            {{ $products->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('this-js')
    <script type="text/javascript">
        function toggleDeletedProduct(button, id) {
            console.log($(button));
            console.log(`enter function id ${id}`)
            var restoreBtn = document.getElementById('restoreBtn');
            // Send an AJAX request to fetch categories based on showDeleted value
            $.ajax({
                url: "{{ route('products.restore') }}",
                type: "put",
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    var deleteLink = $('<a>', {
                        href: "{{ route('products.delete', ':id') }}".replace(':id', id),
                        class: 'btn btn-danger',
                        onclick: "return confirm('Are you sure you want to delete this product?')",
                        text: 'Delete'

                    });
                    $(button).replaceWith(deleteLink);
                }
            });
        }
    </script>
@endsection






