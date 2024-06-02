<option value=""> --- Chọn ---</option>
@foreach($districts as $district)
    <option value="{{$district->code}}">{{$district->full_name}}</option>
@endforeach
