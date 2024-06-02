@extends('admin.layouts.admin')

@section('title')
<title>Trang Chủ Admin</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
     @include('admin.partials.content-header',['name' => '', 'key' => 'Home','url' => '']);
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="div col-md-12">
                        Trang Chủ
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection






