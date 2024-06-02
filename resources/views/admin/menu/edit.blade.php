@extends('admin.layouts.admin')

@section('title', )
<title>Edit {{$menu->name}} Menu </title>

@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header',['name' => 'Menus', 'key' => 'Edit','url' => route('menus')])
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="display: flex; justify-content: end;">
                        <a href="{{route('home')}}" class="btn btn-primary m-2">Home</a>
                    </div>
                </div>
                <div class="row">
                    <div class="div col-md-3">
                        <form action='{{route('menus.update', $menu->id)}}' method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="menuName">Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="menuName"
                                       aria-describedby="menuName"
                                       placeholder="Enter menuName" name="name"
                                       value="{{ old('name', $menu->name) }}">
                                {{--                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="parentMenu">Select Parent Menu</label>
                                <select class="form-control @error('parent_id') is-invalid @enderror" id="parentMenu" name="parent_id">
{{--                                    <option value="0" @if($menu->parent_id === 0) selected disabled @endif>--}}
                                    <option value="0" >
                                        Chọn là Menu cha
                                    </option>
                                    {!! $options !!}
                                </select>
                                @error('parent_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection






