@foreach($reviews as $review)
    @php
        $user = $review->user;
    @endphp
    <div class="review-product-rating">
        <a class="review-product-rating__avatar"
           href="javascript:void(0)">
            <div class="review-avatar">
                <img class="review-avatar__img"
                     src="{{asset($user?$user->avatar:'/storage/users/avatar/default_user.png')}}">
            </div>
        </a>
        <div class="review-product-rating__main">
            <div
                class="review-product-rating__author-name">{{$review->name}}
            </div>
            <div class="repeat-purchase-con">
                <div class="review-product-rating__rating">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            <i class="fa fa-star"
                               style="color: #eca330"></i>
                            <!-- Full yellow star -->
                            {{--                                                                                @elseif ($i == $fullStars + 1 && $halfStar)--}}
                            {{--                                                                                    <i class="fa fa-star-half" style="color: #eca330"></i> <!-- Half yellow star -->--}}
                        @else
                            <i class="fa fa-star"
                               style="color: #ddd"></i>
                            <!-- Empty grey star -->
                        @endif
                    @endfor
                </div>
            </div>
            <div
                class="review-product-rating__time">{{$review->created_at->format('H:i d/m/Y')}}
            </div>
            <div
                style="position: relative; box-sizing: border-box; margin: 15px 0px; font-size: 14px; line-height: 20px; color: rgba(0, 0, 0, 0.87); word-break: break-word;">
                <div
                    style="margin-top: 0.75rem;font-size: 1.2em;">
                    {{$review->review_text}}
                </div>
                <div
                    style="position: absolute; right: 0px; bottom: 0px; background: linear-gradient(to left, rgb(255, 255, 255) 75%, rgba(255, 255, 255, 0)); padding-left: 24px;">
                </div>
            </div>
            @if(trim($review->shop_response??''))
                <div class="TQTPT9">
                    <div class="xO9geG">phản hồi của Người Bán
                    </div>
                    <div
                        class="qiTixQ">{{$review->shop_response}}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endforeach
