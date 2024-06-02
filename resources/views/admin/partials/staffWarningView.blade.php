@if(trim($order->staff_note??''))
    <i class="fas fa-exclamation-triangle staffNoteWarning" id="staffNoteWarning_{{$order->id}}"></i>
@endif
