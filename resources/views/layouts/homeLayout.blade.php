<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <link href="{{asset("home/image/catalog/icon-1.png")}}" rel="icon" />
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/nitro-combined.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/bootstrap/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/soconfig/css/lib.css")}}">
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/ie9-and-up.css")}}">
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/search.css")}}">

    <link rel="stylesheet" href="{{asset("home/theme/batosa/fonts/glytus/glytus.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/so_newletter_custom_popup/css/style.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/so_megamenu/so_megamenu.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/so_megamenu/wide-grid.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/so_page_builder/css/style_render_249.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/so_page_builder/css/style.css")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/so_searchpro/css/so_searchpro.css")}}">
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/custom502b.css?v=52")}}">
    <link rel="stylesheet" href="{{asset("home/javascript/soconfig/css/owl.carousel.css")}}">
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/layout1/red.css")}}">
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/responsive.css")}}">
    <link rel="stylesheet" href="{{asset('home/css/all.min.css')}}">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.0/css/all.css">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto+Slab|Roboto:300,400,400i,700&amp;subset=vietnamese" media="all"
          type="text/css" />
    <style>
        #header.hfixed .header-bottom{
            position: fixed;
            width: 100%;
            left: 0;
            top: 0;
            z-index: 100;
        }
        #angle-left, #angle-right {
            display: none;
        }
        @media (min-width: 480px) {
            #angle-left, #angle-right {
                display: unset;
            }
        }
        .subTotalSumPrice {
            display: flex;
            justify-content: space-between;
            padding-inline: 19px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .countdown_inner{
            display: flex;
        }

        @media (min-width: 1200px) {

        }
        .countdown_inner .title {
            flex-basis: 40%;
        }
        .time-item {
            flex-basis: 0;
            flex-grow: 1;
        }
        .countdown_inner .defaultCountdown-3667 {
            flex-basis: 60%;
            /*flex-grow: 1;*/
        }
        .num-time, .name-time {
            min-width: 20px;
            padding: 0 !important;
        }

    </style>
    @yield('this-css-library')
    @yield('this-css')
</head>
<body class="hold-transition sidebar-mini ">
<div class="wrapper">
    <input type="hidden" id="currentRoute" value="{{ Route::currentRouteName() }}">
    @include('partials.header',['parentCategories' => $parentCategories])

    @yield('content')

    @include('partials.footer')

{{--    error indicator--}}
    @if (session('error'))
        <script>
            // Show alert with the error message
            alert("{{ session('error') }}");
        </script>
    @endif
    @if (session('success'))
        <script>
            // Show alert with the error message
            alert("{{ session('success') }}");
        </script>
    @endif
</div>

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src={{asset("home/javascript/jquery/jquery-2.1.1.min.js")}}></script>
<script src={{asset("home/javascript/bootstrap/js/bootstrap.min.js")}}></script>
<script src={{asset("home/javascript/soconfig/js/libs.js")}}></script>
<script src={{asset("home/javascript/soconfig/js/so.system.js")}}></script>
<script src={{asset("home/theme/batosa/js/so.custom.js")}}></script>
<script src={{asset("home/theme/batosa/js/jquery.matchHeight-min.js")}}></script>
<script src={{asset("home/theme/batosa/js/classie.js")}}></script>
<script src={{asset("home/theme/batosa/js/common.js")}}></script>
<script src={{asset("home/javascript/soconfig/js/owl.carousel.js")}}></script>
<script src={{asset("home/javascript/so_megamenu/so_megamenu.js")}}></script>
<script src={{asset("home/javascript/so_page_builder/js/section.js")}}></script>
<script src={{asset("home/javascript/so_page_builder/js/swfobject.js")}}></script>
<script src={{asset("home/javascript/soconfig/js/cpanel.js")}}></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>


<script type="text/javascript">
    $(function ($) {
        var $nav = $("#popup0");
        $nav.each(function () {
            $(this).owlCarousel2({
                nav: true,
                dots: false,
                slideBy: 1,
                margin: 10,
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                smartSpeed: 550,
                navText: ['<i class="fa fa-angle-left" id="angle-left"></i>', '<i class="fa fa-angle-right" id="angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });
        })

    });
</script>
<script type="text/javascript">
    $('#search .opens').click(function () {
        $('#search').toggleClass('open');
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $header = $("header");
        headerStaticHeight = $header.outerHeight() - $('.header-bottom').outerHeight();
            $(window).scroll(function(){
                var sticky = $('#header'),
                    scroll = $(window).scrollTop();
                if (scroll >= headerStaticHeight) sticky.addClass('hfixed');
                else sticky.removeClass('hfixed');
            });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.banner-top-home .banners').owlCarousel2({
            margin: 0,
            items: 3,
            nav: false,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            autoplay: 400,
            autoWidth: false,
            dots: true,
            responsive: {
                0:  { items: 2 } ,
                480: { items:2 },
                768: { items: 3 }
            },
        });
        $('.product-item-content').matchHeight();
        $('.product-thumb .price').matchHeight();
        $('.product-thumb h4').matchHeight();
        $('.related-blogs-list .blog-item .caption').matchHeight();
        $('.related-blogs-list .blog-item .caption a').matchHeight();
        $('.related-blogs-list .blog-item .caption .description').matchHeight();

        if($('.category-info .description-box .desc-content > div').height()>150){
            $('.description-box .readmore').click(function(){
                $('.description-box').addClass('open');
            });
        }else{
            $('.category-info').addClass('remove-readmore');
        }
    });

</script>
<script type="text/javascript">
    // Cart functionalities
    function removeFromCart(thisEl) {
        var $this = $(thisEl);
        alertify.confirm('Xóa Sản Phẩm?', 'Toàn bộ sản phẩm với Size tương ứng sẽ bị xóa!', function () {
                // alertify.success('Ok clicked')
                var url = '{{ route('removeFromCart') }}';
                var sizeId = $this.data('sizeid')
                var productId = $this.data('productid')

                $.ajax({
                    url: url,
                    type: 'POST', // Change to POST method as we are sending data
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token for security
                        sizeId: sizeId,
                        productId: productId
                    },
                    beforeSend: function () {
                        alertify.notify('Đang Xóa Sản Phẩm Khỏi Giỏ Hàng', 'success', 5, function(){  console.log('dismissed'); });
                    },
                    complete: function () {
                        // $('#button-cart').button('reset');
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#shoppingcart-box").html(response.view); // Update the cart view with rendered HTML
                            var cartQty = $('#cartItemNumbersData').val();
                            $("#cartItemNumbers").html(cartQty)
                            alertify.success('Đã xóa sản phẩm'); // Show success message
                            var currentRoute = $('#currentRoute').val(); // Using hidden input
                            // alertify.success(currentRoute);
                            if (currentRoute === 'cartDisplay' || currentRoute === 'checkout') {
                                location.reload(); // Reload the page if the current route is 'cart'
                            }
                        } else {
                            alertify.error(response.msg); // Show error message if product could not be added
                        }
                    },
                    error: function (xhr, status, error) {
                        alertify.error('Xóa sản phẩm khỏi giỏ hàng thất bại'); // Show generic error message
                        console.error(xhr.responseText); // Log the error for debugging
                    }
                });

            }
            , function () {
                // alertify.error('Cancel clicked');
            });
    }
</script>

@yield('this-js-library')
@yield('this-js')
</body>
</html>
