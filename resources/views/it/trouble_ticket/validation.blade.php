<div class="float-right">
  @if ($record->status == 'open')
  <a href="/it/trouble_ticket/{{$record->id}}/edit" class="back btn btn-info">Edit</a>
  @else
  	@if ($record->status != 'close')
	  	@if ($record->actioned_by_id != null && $record->actioned_by_id == auth()->user()->id)
	  		<a href="/it/trouble_ticket/{{$record->id}}/edit" class="back btn btn-info">Edit</a>
	  	@endif
	  @endif
  @endif
  <a href="/it/trouble_ticket" class="back btn btn-secondary">Back</a>
</div>