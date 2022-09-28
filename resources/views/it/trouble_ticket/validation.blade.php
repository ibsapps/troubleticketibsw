<div class="float-right">
  @if ($record->status == 'open')
  <a href="/it/trouble_ticket/{{$record->id}}/edit" class="back btn btn-info">Edit</a>
  @else
  @endif
  <a href="/it/trouble_ticket" class="back btn btn-secondary">Back</a>
</div>