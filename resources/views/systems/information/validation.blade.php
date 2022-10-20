<div class="float-right">
	@if ($permission->modify == 1)
	  <a href="/sys/information/{{$record->id}}/edit" class="back btn btn-info">Edit</a>
  @endif
  <a href="/sys/information" class="back btn btn-secondary">Back</a>
</div>