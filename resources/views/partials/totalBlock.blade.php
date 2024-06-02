
<div class="row" id="VoucherApplied">
    <label
        class="col-sm-9 col-xs-6 control-label">Mã
        Giảm Giá
    </label>
    <div
        class="col-sm-3 col-xs-6 form-control-static text-right">
        {{number_format($discount ,0,',','.')}} đ
    </div>
    <input type="hidden" name="voucherCode" value="{{$voucherCode}}">
</div>
<div class="row" id="Total">
    <label
        class="col-sm-9 col-xs-6 control-label">Tổng
        cộng </label>
    <div
        class="col-sm-3 col-xs-6 form-control-static text-right">
        {{number_format($newTotalPrice ,0,',','.')}} đ
    </div>
    <input type="hidden" name="cartTotalPrice" value="{{$newTotalPrice}}">
</div>
