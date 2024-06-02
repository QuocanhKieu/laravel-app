@extends('admin.layouts.admin')

@section('title')
    <title>Add Delivery Information </title>
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
        img {
            max-width: 100%;
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header',['name' => 'Danh sách Orders', 'key' => 'Add Delivery','url' => route('orders')])
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="div col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Thông Tin Vân Chuyển và Mã Vận Đơn cho đơn hàng #{{$order->order_code}}</h5>
                                <hr>
                                <form id="form">
                                    <div class="form-group">
                                        <label for="delivery_unit">Đơn vị vận chuyển</label>
                                        <input type="text" class="form-control "
                                               id="delivery_unit"
                                               aria-describedby="delivery_unit"
                                               placeholder="Enter delivery_unit" name="delivery_unit"
                                                value="{{$order->shippingInfo?$order->shippingInfo->delivery_unit:''}}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="delivery_code">Mã Vận Đơn</label>
                                        <input type="text" class="form-control"
                                               id="delivery_code"
                                               aria-describedby="delivery_code"
                                               placeholder="Enter delivery_code" name="delivery_code"
                                            value="{{$order->shippingInfo?$order->shippingInfo->delivery_code:''}}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="delivery_method">Hình thức vận chuyển</label>
                                        <input type="text" class="form-control"
                                               id="delivery_method"
                                               aria-describedby="delivery_method"
                                               placeholder="Enter delivery_method" name="delivery_method"
                                               value="{{$order->shippingInfo?$order->shippingInfo->delivery_method:''}}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="real_delivery_fee">Phí vận chuyển thực tế</label>
                                        <input type="number" class="form-control"
                                               id="real_delivery_fee"
                                               aria-describedby="real_delivery_fee"
                                               placeholder="Enter real_delivery_fee" name="real_delivery_fee"
                                               value="{{$order->shippingInfo?$order->shippingInfo->real_delivery_fee:''}}"
                                        >
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
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
        $('#submitButton').click(function(e) {
            e.preventDefault();
            var formData = $('#form').serialize();
            // Manually serialize extra fields outside the form
            var extraFieldData = {
                order_id:  {{$order->id}},
            };
            //
            // // Combine both serialized data
            var combinedData = formData + '&' + $.param(extraFieldData);
            // Perform AJAX request to process the entire form
            var url = '{{route('orders.updateDelivery')}}';
            $.ajax({
                type: 'POST',
                url: url, // Laravel route for processing the form
                data: combinedData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success response
                    if (response.success) {
                        // Redirect to success page or show success message
                        alertify.success(response.message);
                    } else {
                        // Display Laravel validation errors if any
                        // if (response.errors) {
                        //     $.each(response.errors, function(key, value) {
                        //         $('#' + key + '-error').html(value[0]).show(); // Show error message
                        //     });
                        // }
                        alertify.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    console.error('AJAX Error: ' + error);
                    alertify.error(response.message);
                }
            });
        });
    </script>
@endsection





