@extends('layouts.admin')

@section('title', )
<title>Danh Sách Menus</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header',['name' => '', 'key' => 'Menus','url' => ''])

        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="display: flex; justify-content: end;" >
                        <a href="{{route('menus.create')}}" class="btn btn-primary m-2">Create Menu</a>
                    </div>
                    <div class="div col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Parent_id</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    <tr>
                                        <th scope="row">{{$menu->id}}</th>
                                        <td>{{$menu->name}}</td>
                                        <td>{{$menu->parent_id}}</td>
                                        <td>
                                            <a href="{{route('menus.edit', $menu->id)}}" class="btn btn-primary">Edit</a>
{{--                                            <a href="{{route('menus.delete', $menu->id)}}" class="btn btn-danger">Delete</a>--}}
                                            <a href="{{route('menus.delete', $menu->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this menu?')">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                        <!--                        pagination start-->

                        <div class="col-md-12">
                            {{ $menus->links('vendor.pagination.bootstrap-4') }}
                        </div>
<!--                        pagination end-->
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    @if (session('error'))
        <script>
            // Show alert with the error message
            alert("{{ session('error') }}");
        </script>
    @endif

@endsection






