<div class="d-flex justify-content-end">
  @if ($record->status == 1)
  <div class="col-sm-1">
    <a href="/hrd/employee/{{ $record->id}}/edit" class="btn btn-info">Edit</a>
  </div>
  @endif
  <div class="col-sm-1">
    <a href="/hrd/employee" class="btn btn-secondary">Back</a>
  </div>
</div>