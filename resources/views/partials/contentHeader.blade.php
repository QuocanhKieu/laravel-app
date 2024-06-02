<!-- resources/views/partials/content_header.blade.php -->
@if(!empty($breadcrumbs))
{{--    <div class="content-header">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row mb-2">--}}
{{--                <div class="col-sm-6">--}}
{{--                    --}}{{-- Customize the header title as needed --}}
{{--                    <h1 class="m-0 text-dark">{{ end($breadcrumbs)['name'] }}</h1>--}}
{{--                </div><!-- /.col -->--}}
{{--                <div class="col-sm-6">--}}
{{--                    <ol class="breadcrumb float-sm-right">--}}
{{--                        @foreach($breadcrumbs as $breadcrumb)--}}
{{--                            @if (!$loop->last)--}}
{{--                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li><&nbsp;<i class="fa-solid fa-angle-right">&nbsp;</i> '>--}}
{{--                            @else--}}
{{--                                <li class="breadcrumb-item active">{{ $breadcrumb['name'] }}</li>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </ol>--}}
{{--                </div><!-- /.col -->--}}
{{--            </div><!-- /.row -->--}}
{{--        </div><!-- /.container-fluid -->--}}
{{--    </div>--}}
    <div class="sub-header">
        <div class="container ">
            <ul class="breadcrumb">
                @foreach($breadcrumbs as $breadcrumb)
                    @if (!$loop->last)
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                    @else
                        <li class="breadcrumb-item active">{{ $breadcrumb['name'] }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif
{{--// In your Controller--}}

{{--public function someFunction()--}}
{{--{--}}
{{--$breadcrumbs = [--}}
{{--['name' => 'Home', 'url' => route('home')],--}}
{{--['name' => 'Category', 'url' => route('category')],--}}
{{--['name' => 'Subcategory', 'url' => route('subcategory')],--}}
{{--['name' => 'Current Page', 'url' => ''] // No URL for the current page--}}
{{--];--}}

{{--return view('your_view', compact('breadcrumbs'));--}}
{{--}--}}


