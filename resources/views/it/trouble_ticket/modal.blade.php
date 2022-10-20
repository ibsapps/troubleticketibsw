
<form method="POST" action="/it/trouble_ticket/{{ $record->id }}" enctype="multipart/form-data" class="edit_form">
  @method('PUT')
  @csrf
  @if (session('error'))
  <div class="alert alert-danger" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session('error') }}
  </div>
  @endif
  <input type="hidden" id="id" name="id" value="{{ $record->id }}">
  <input type="hidden" id="updated_by" name="updated_by" value="{{ auth()->user()->id }}">
  <input type="hidden" id="process" name="process" value="modal">

  <div class="message" style="display: none;"></div>
  <div class="form-group row">
    <label class="col-lg-1 col-form-label">User</label>
    <div class="col-lg-2">
      <input type="text" id="user_name" name="user_name" class="form-control" value="{{ $record->user->ibs_employee->name }}" readonly>
    </div>
    <label class="col-lg-1 col-form-label">Department</label>
    <div class="col-lg-2">
      <input type="text" id="department_name" name="department_name" class="form-control" value="{{ $record->user->ibs_employee->ibs_department->name }}" readonly>
    </div>
    <label class="col-lg-1 col-form-label">Date</label>
    <div class="col-lg-2">
      <input type="date" id="ticket_date" name="ticket_date" class="form-control" value="{{ $record->request_date->format('Y-m-d') }}" readonly>
    </div>
    <label class="col-lg-1 col-form-label">Due Date</label>
    <div class="col-lg-2">
      @if ($record->due_date == null)
        <input type="date" id="due_date" name="due_date" class="form-control" required="true">
      @else
        <input type="date" id="due_date" name="due_date" class="form-control" value="{{ $record->due_date->format('Y-m-d') }}" readonly>
      @endif
    </div>
  </div>
  <div class="form-group row">
    <label class="col-lg-1 col-form-label">Category</label>
    <div class="col-lg-2">
      <input type="text" id="category_name" name="category_name" class="form-control" value="{{ $record->ibs_trouble_ticket_category->name }}" readonly>
    </div>
    <label class="col-lg-1 col-form-label">Priority</label>
    <div class="col-lg-2">
      <input type="text" name="priority" id="priority" class="form-control" value="{{ $record->priority }}" readonly>
    </div>
    @if (auth()->user()->ibs_employee->ibs_department_id == 2)
      <label class="col-lg-1 col-form-label">Status</label>
      <div class="col-lg-2">
        @if ($record->actioned_by_id != null && $record->actioned_by_id != auth()->user()->id)
          <input type="text" name="status" id="status" class="form-control" value="{{ $record->status }}" readonly="true">
        @else
          <select name="status" id="status" class="form-control" <?= $record->status == 'close' ? 'disabled' : '' ?>>
            @if ($record->status == 'open')
              <option value="open" selected>Open</option>
            @endif
            <option value="on progress" {{ $record->status == 'on progress' ? 'selected' : '' }}>On Progress</option>
            <option value="close" {{ $record->status == 'close' ? 'selected' : '' }}>Close</option>
            <option value="reject" {{ $record->status == 'reject' ? 'selected' : '' }}>Reject</option>
          </select>
        @endif
      </div>
      <label class="col-lg-1 col-form-label">PIC</label>
      <div class="col-lg-2">
        @if ($record->actioned_by_id != null || $record->actioned_by_id == auth()->user()->id )
          <input type="hidden" name="actioned_by_id" id="actioned_by_id" class="form-control" readonly="true" value="{{ $record->actioned_by_id }}">
          <input type="text" name="pic_name" id="pic_name" class="form-control" readonly="true" value="{{ $record->actioned_by->fullname }}">
        @else
          <select name="actioned_by_id" id="actioned_by_id" class="form-control">
            <option value="">- Select -</option>
            @foreach ($superiors as $superior)
              <option value="{{ $superior->user_id }}" {{ $record->actioned_by_id == $superior->user_id ? 'selected' : ''}}>{{ $superior->user->fullname }}</option>
            @endforeach
          </select>
        @endif
      </div>
    @endif
  </div>
  <div class="form-group row">
    <label class="col-lg-1 col-form-label">Trouble</label>
    <div class="col-lg-5">
      <input type="text" id="request" name="request" class="form-control" value="{{ $record->request }}" {{ $record->user_id != auth()->user()->id ? 'readonly' : '' }}>
    </div>
    @if ($record->status != 'open')
      <label class="col-lg-1 col-form-label">Repaired</label>
      <div class="col-lg-2">
        @if ($record->actioned_by_id != null && $record->actioned_by_id == auth()->user()->id)
          <select name="trouble_repair" id="trouble_repair" class="form-control" <?= $record->status == 'close' ? 'disabled' : 'required' ?>>
            <option value="">- Select -</option>
            <option value="internal" {{ $record->trouble_repair == 'internal' ? 'selected' : '' }}>Internal</option>
            <option value="external" {{ $record->trouble_repair == 'external' ? 'selected' : '' }}>External</option>
          </select>
        @else
          <input type="text" name="trouble_repair" id="trouble_repair" class="form-control" value="{{ $record->trouble_repair }}" disabled="true">
        @endif
      </div>
      <div class="col-lg-3">
        <select name="ibs_vendor_id" id="ibs_vendor_id" class="form-control" style="display: <?= $record->trouble_repair == null || $record->trouble_repair == 'internal' ? 'none' : 'display' ?>;" <?= $record->status == 'close' ? 'disabled' : '' ?>>
          <option value="">- Select -</option>
          @foreach ($vendors as $vendor)
            <option value="{{ $vendor->id }}" {{ $record->ibs_vendor_id == $vendor->id ? 'selected' : ''   }}>{{ $vendor->name }}</option>
          @endforeach
        </select>
      </div>
    @endif
  </div>
  <div class="form-group row">
    <label class="col-lg-1 col-form-label">Description</label>
    <div class="col-lg-5">
      @if ($record->status == 'open')
        <textarea id="description" name="description" rows="5" class="form-control" {{ $record->user_id != auth()->user()->id ? 'readonly' : '' }}>{{ $record->description }}</textarea>
      @else
        <textarea name="description" id="description" rows="5" class="form-control" readonly>{{ $record->description }}</textarea>
      @endif
    </div>
    <label class="col-lg-1 col-form-label">Attachment</label>
    <div class="col-lg-2">
      @if (!empty($record->filename_original))
        <a href="{!! asset($record->file_path) !!}" target="_blank"><img src="{!! asset($record->file_path) !!}" alt=" {{ $record->filename_original }}" style="width:100px;height:100px;"></a>
      @else
        <input type="file" name="file" id="file" class="btn btn-default btn-block btn-sm" accept="image/*" disabled="true">
      @endif
      @if ($record->status == 'open')
        <input type="file" name="file" id="file" class="btn btn-default btn-block btn-sm" accept="image/*" {{ $record->user_id != auth()->user()->id ? 'disabled' : '' }}>
      @endif
    </div>
  </div>
  <hr>
  @if ($record->actioned_by_id == null)
    @if ($record->status == 'open')
      <button type="submit" class="save btn btn-primary" data-toggle="tooltip" title='Save'>Save</button>
    @endif
  @else
    @if ($record->status == 'open' || $record->status == 'on progress')
      @if ($record->actioned_by_id == auth()->user()->id)
        <button type="submit" class="save btn btn-primary" data-toggle="tooltip" title='Save'>Save</button>
      @endif
    @endif
  @endif
  <button type="button" class="back btn btn-secondary" data-dismiss="modal">Close</button>
</form>

<script type="text/javascript">
  $('#trouble_repair').change(function(event) {
    var kind = $(this).val();
    // alert(kind);
    if (kind == 'external') {
      $("#ibs_vendor_id").show();
    } else {
      $("#ibs_vendor_id").hide();
      $("#ibs_vendor_id").val();
    }
    return false;
  });
</script>