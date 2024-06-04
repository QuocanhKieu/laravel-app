@extends('admin.layouts.admin')
@section('title')
    <title>Danh Sách Đánh Giá</title>
@endsection
@section('this-css')
    <link rel="stylesheet" href="{{asset('admins/css/select2.min.css')}}">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .deliveryFeeInput {
            max-width: 90px;
            padding-block: 0;
            height: auto !important;
        }

        .color-indicator {
            height: 8px;
            width: 100%;
            /* border-radius: 50%; */
            position: absolute;
            top: 0;
        }

        .cancelReasonBox {
            position: absolute;
            top: -22px;
            right: -25px;
            font-size: 24px;
            color: #f14d68;
        }

        .staffNote {
            vertical-align: text-top;
            font-size: 21px;
            margin-left: 10px;

        }

        td, th {
            vertical-align: middle !important;
        }

        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000; /* Ensure it is above other content */
        }

        .spinner {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .staffNoteWarning {
            position: absolute;
            font-size: 16px;
            top: -7px;
            right: -8px;
            color: #ff031b;
        }

        .orderNoteDisplay {
            position: absolute;
            font-size: 22px;
            top: -36px;
            right: -16px;
        }

        .shippingInfoIcon {
            color: #22d271;
        }

        #order_status, #payment_status {
            min-width: 300px;
            width: 30%;
        }

        /*.delete-order {*/
        /*    padding: 5px;*/
        /*}*/
    </style>
@endsection
@section('content')
    @php
        $REVIEW_STATUSES = App\Constants\ReviewStatusConstants::REVIEWSTATUSES;
        $STATUS_COLORS = App\Constants\ReviewStatusConstants::REVIEWSTATUSCOLORS;
    @endphp
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name' => '', 'key' => 'Danh Sánh Đánh Giá','url' => ''])
        <form class="form-inline ml-3" method="GET" action="{{ route('reviews') }}">
            <input type="hidden" name="sort_by" value="{{ request('sort_by', $sortBy) }}">
            <input type="hidden" name="sort_direction" value="{{ request('sort_direction', $sortDirection) }}">
            <input type="hidden" name="show_deleted" value="{{ request('show_deleted', $showDeleted) }}">
            <input type="hidden" name="page" value="{{ $reviews->currentPage() }}">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" value="{{ request('search_term', $searchTerm) }}" name="search_term">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="content">
            <form method="GET" action="{{ route('reviews') }}" style="padding-left: 13px;">
                <input type="hidden" name="sort_by" value="{{ request('sort_by', $sortBy) }}">
                <input type="hidden" name="sort_direction" value="{{ request('sort_direction', $sortDirection) }}">
                <input type="hidden" name="search_term" value="{{ request('search_term', $searchTerm) }}">
                <input type="hidden" name="page" value="{{ $reviews->currentPage() }}">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="show_deleted" id="show_deleted" value="yes" {{ $showDeleted === 'yes' ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_deleted">
                        Hiển thị reviews đã xóa
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
            <div class="container-fluid">
                <div class="row">
                    <div class="div col-md-12">
                        <div id="cartsTable">
                            <table class="table">
                                <thead>
                                <tr>
                                    @php
                                        $columns = [
                                         'id' => ['name' => 'ID', 'sortable' => true],
                                         'name' => ['name' => 'UserID|Họ và tên', 'sortable' => true],
                                         'product_id ' => ['name' => 'Tên Sản Phẩm', 'sortable' => true],
                                         'review_text' => ['name' => 'Đánh Giá chi tiết', 'sortable' => true],
                                         'rating' => ['name' => 'Số sao', 'sortable' => true],
                                         'status' => ['name' => 'Trạng Thái', 'sortable' => true],
                                         'shop_response' => ['name' => 'Phản Hồi Đánh Giá', 'sortable' => true],
                                         'created_at' => ['name' => 'Ngày tạo', 'sortable' => true],
                                     ];
                                    @endphp

                                    @foreach($columns as $column => $details)
                                        <th>
                                            @if($details['sortable'])
                                                <a
                                                    href="{{ route('reviews', [
                                                        'sort_by' => $column,
                                                        'sort_direction' => $sortBy === $column && $sortDirection === 'asc' ? 'desc' : 'asc',
                                                        'search_term' => request('search_term', $searchTerm),
                                                        'show_deleted' => request('show_deleted', $showDeleted),
                                                        'page' => $reviews->currentPage(), // Preserve current page
                                                    ]) }}"
                                                >
                                                    {{ $details['name'] }}
                                                    @if($sortBy === $column)
                                                        <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                                    @endif
                                                </a>
                                            @else
                                                {{ $details['name'] }}
                                            @endif
                                        </th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $review)
                                    @php
                                        $product = $review->product;
                                        $reviewStatus = $review->status;
                                        $createdAt = $review->created_at;
                                    @endphp
                                    <tr>
                                        <td style="">
                                            {{$review->id}}
                                        </td>
                                        <td>{{($review->user_id?$review->user_id:'Guest').'|'.$review->name}}</td>
                                        <td>{{$product->name}}</td>
                                        <td style="width:10%;">
                                            {{$review->review_text}}
                                        </td>
                                        <td>{{$review->rating}} Sao</td>
                                        <td>
                                            <div class="form-group" style="position: relative">
                                                <select
                                                    class="form-control review-status"
                                                    name="paymentStatus"
                                                    data-review-id="{{$review->id}}"
                                                >
                                                    @foreach( $REVIEW_STATUSES as $key => $status)
                                                        <option
                                                            value="{{$status}}"
                                                            {{ $status === $reviewStatus ? 'selected' : '' }} data-color="{{$STATUS_COLORS[$status]}}">
                                                            {{ $status  }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="color-indicator"
                                                     style="background-color: {{ $STATUS_COLORS[$reviewStatus] ?? 'transparent' }};"></div>
                                                <input type="hidden" class="previous-review-status"
                                                       value="{{ $reviewStatus }}">
                                            </div>
                                        </td>
                                        <td id="shopResponse_{{$review->id}}"><a href="javascript:void(0);" data-review-id="{{$review->id}}" onclick="submitReviewResponse(this)">Phản Hồi</a>
                                            @if(trim($review->shop_response??''))
                                                <i class="fas fa-check-circle reviewResponseWarning" id="reviewResponseWarning_{{$review->id}}" style="    color: #00ad00;
    font-size: 1.2em;"></i>
                                            @endif
                                        </td>
                                        <td>{{ $createdAt }}</td>
                                        <td>
                                            @if($review->deleted_at)
                                                <button type="button" class="btn btn-success"
                                                        onclick="restoreReview(this, {{ $review->id}})" title="Restore"
                                                        id="restoreBtn"><i class="fas fa-undo"></i>
                                                </button>
                                            @else
                                                <a title="Delete" href="javascript:void(0);" class="btn btn-danger delete-review"
                                                   style=""
                                                   data-url="{{route('reviews.delete', $review->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-12">
                                {{ $reviews->appends([
                                    'sort_by' =>  request('sort_by', $sortBy),
                                    'sort_direction' =>  request('sort_direction', $sortDirection),
                                    'show_deleted' => request('show_deleted', $showDeleted),
                                    'search_term' => request('search_term', $searchTerm)
                                ])->links('vendor.pagination.bootstrap-4') }}
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

        function submitReviewResponse(thisEl) {
            var $this = $(thisEl);
            var reviewId = $this.data('review-id');
            var shopResponse = ''
            var url = '{{ route('reviews.getSubmitReviewResponse') }}';
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    reviewId: reviewId,
                }, beforeSend: function () {
                    // Disable the link
                    $this.addClass('disabled');
                    $this.css('pointer-events', 'none');
                },
                complete: function () {
                    // Enable the link
                    $this.removeClass('disabled');
                    $this.css('pointer-events', '');
                },
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function (response) {
                    if (response.success) {
                        shopResponse = response.shopResponse;
                        alertify.prompt('Phản hồi của Người Bán', '', shopResponse
                            , function (evt, newShopResponse) {
                                var url = '{{ route('reviews.submitReviewResponse') }}';
                                $.ajax({
                                    url: url,
                                    method: 'POST',
                                    data: {
                                        newShopResponse: newShopResponse,
                                        reviewId: reviewId,
                                    }, beforeSend: function () {
                                        // Disable the link
                                        $this.addClass('disabled');
                                        $this.css('pointer-events', 'none');
                                    },
                                    complete: function () {
                                        // Enable the link
                                        $this.removeClass('disabled');
                                        $this.css('pointer-events', '');
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (response) {
                                        if (response.success) {

                                            $('#reviewResponseWarning_' + reviewId).remove();
                                            $('#shopResponse_' + reviewId).append(response.reviewResponseWarningView);
                                        } else {
                                            alertify.error(response.message);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(xhr.responseText);
                                        alertify.error(xhr.responseText);
                                    }
                                });

                            }
                            , function () {

                                alertify.error('Cancel')

                            })
                            .set('labels', {ok: 'Save', cancel: 'Cancel'});
                    } else {
                        alertify.error(response.message);
                        shopResponse = ''
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alertify.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function () {
            function updateColor($select) {
                var selectedOption = $select.find('option:selected');
                var color = selectedOption.data('color');
                $select.siblings('.color-indicator').css('background-color', color);
            }

            // Initialize background colors and color indicators for all selects
            $('.review-status').each(function () {
                updateColor($(this));
            });
            // Event listener for change on .review-status selects
            $('.review-status').change(function () {
                var $select = $(this);
                var $hiddenInput = $select.siblings('.previous-review-status'); // Find corresponding hidden input
                var previousValue = $hiddenInput.val(); // Get previous selected value from hidden input

                // Show confirmation dialog using alertify
                alertify.confirm('Confirm Message', 'Are you sure you want to change Review Status?',
                    function () { // On confirm
                        var reviewId = $select.data('review-id');
                        var newStatus = $select.val();//newStatus for db table but is current status of the select

                        // Example of AJAX request to update order status
                        var url = '{{ route('reviews.updateReviewStatus') }}';
                        $.ajax({
                            url: url,
                            method: 'PUT',
                            data: {
                                reviewId: reviewId,
                                newStatus: newStatus
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.success) {
                                    alertify.success(response.message);
                                    // Update hidden input with new value after successful update
                                    $hiddenInput.val(newStatus);
                                    $select.val(newStatus);
                                    //important for the updateColor work correctly
                                    $select.find('option').removeAttr('selected');
                                    $select.find('option[value="' + newStatus + '"]').attr('selected', true);
                                    updateColor($select);
                                } else {
                                    alertify.error(response.message);
                                    // Revert to previous value on error
                                    $select.val(previousValue);
                                    //important for the updateColor work correctly
                                    $select.find('option').removeAttr('selected');
                                    $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                                    updateColor($select);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                alertify.error(xhr.responseText);
                                // Revert to previous value on error
                                $select.val(previousValue);
                                //important for the updateColor work correctly
                                $select.find('option').removeAttr('selected');
                                $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                                updateColor($select);
                            }
                        });
                    },
                    function () { // On cancel
                        // Revert to previous value
                        $select.val(previousValue);
                        //important for the updateColor work correctly
                        $select.find('option').removeAttr('selected');
                        $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                        updateColor($select);
                        alertify.error('Cancel');
                    }
                );
            });
        });

        $(document).ready(function () {
            $(document).on('click', '.delete-review', function(e) {
                e.preventDefault(); // Prevent the default action of the link

                var $this = $(this); // Capture the clicked element

                alertify.confirm(
                    'Confirm Message',
                    'Are you sure you want to delete this Review?',
                    function () {
                        window.location.href = $this.data('url'); // Use the data-url attribute for the redirect
                    },
                    function () {
                        alertify.error('Cancel'); // Handle cancel action
                    }
                );
            });
        });

        function restoreReview(button, review_id) {
            // Confirm before sending the AJAX request
            alertify.confirm('Confirm Message', 'Are you sure you want to restore this Review?',
                function () {
                    // Send an AJAX request to restore the order
                    var url = '{{ route('reviews.restore') }}';
                    $.ajax({
                        url: url,
                        type: "put",
                        data: {
                            review_id: review_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                var deleteLink = $('<a>', {
                                    title: 'Delete',
                                    href: 'javascript:void(0);',
                                    class: 'btn btn-danger delete-review',
                                    'data-url': "{{ route('reviews.delete', ':review_id') }}".replace(':review_id', review_id),
                                    html: '<i class="fas fa-trash"></i>'
                                });
                                $(button).replaceWith(deleteLink);
                                alertify.success(response.message);

                            } else {
                                alertify.error(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            alertify.error('Restore review thất bại'); // Show generic error message
                            console.error(xhr.responseText); // Log the error for debugging
                        }
                    });
                },
                function () {
                    alertify.error('Cancel');
                }
            );
        }
    </script>
@endsection





