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
      <input type="date" id="ticket_date" name="ticket_date" class="form-control" value="{{ $record->request_date }}" readonly>
    </div>
    <label class="col-lg-1 col-form-label">Due Date</label>
    <div class="col-lg-2">
      @if ($record->due_date == null)
        <input type="date" id="due_date" name="due_date" class="form-control" required>
      @else
        <input type="date" id="target_date" name="target_date" class="form-control" value="{{ $record->due_date }}" readonly>
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
        <select name="status" id="status" class="form-control">
          @if ($record->status == 'open')
            <option value="open" selected>Open</option>
          @endif
          <option value="on progress" {{ $record->status == 'on progress' ? 'selected' : '' }}>On Progress</option>
          <option value="close" {{ $record->status == 'close' ? 'selected' : '' }}>Close</option>
          <option value="reject" {{ $record->status == 'reject' ? 'selected' : '' }}>Reject</option>
        </select>
      </div>
      @if (auth()->user()->ibs_employee->ibs_position_id == 2 || auth()->user()->ibs_employee->ibs_position_id == 3 )
      <label class="col-lg-1 col-form-label">PIC</label>
      <div class="col-lg-2">
        <select name="actioned_by_id" id="actioned_by_id" class="form-control" required>
          @foreach ($superiors as $superior)
          <option value="{{ $superior->user_id }}" {{ $record->actioned_by_id == $superior->user_id ? 'selected' : ''}}>{{ $superior->user->fullname }}</option>
          @endforeach
        </select>
      </div>
      @endif
    @endif
  </div>
  <div class="form-group row">
    <label class="col-lg-1 col-form-label">Request</label>
    <div class="col-lg-5">
      <input type="text" id="request" name="request" class="form-control" value="{{ $record->request }}" {{ $record->user_id != auth()->user()->id ? 'readonly' : '' }}>
    </div>
    @if ($record->status != 'open')
      <label class="col-lg-1 col-form-label">Repaired</label>
      <div class="col-lg-2">
        <select name="trouble_repair" id="trouble_repair" class="form-control" required>
          <option>- Select -</option>
          <option value="internal" {{ $record->trouble_repair == 'internal' ? 'selected' : '' }}>Internal</option>
          <option value="external" {{ $record->trouble_repair == 'external' ? 'selected' : '' }}>External</option>
        </select>
      </div>
      <div class="col-lg-3">
        <select name="ibs_vendor_id" id="ibs_vendor_id" class="form-control" style="display: <?= $record->trouble_repair == 'internal' ? 'none' : 'display' ?>;" required>
          <option>- Select -</option>
          @foreach ($vendors as $vendor)
          <option value="{{ $vendor->id }}" {{ $record->ibs_vendor_id == $vendor->id ? 'selected' : ''   }}>{{ $vendor->name }}</option>
          @endforeach
        </select>
      </div>
    @endif
  </div>
  <hr>
  @if ($record->user_id == session('id'))
  <div class="col-lg-6">
    <button type="button" id="add_item" name="add_item" tbl="trouble_ticket" class="btn btn-primary">Add</button>
  </div>
  @endif
  <br>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-bordered" id="tbl_item">
        <thead>
          <tr>
            <th>No.</th>
            <th>Description</th>
            <th>File Upload</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($record_items as $item)
          <tr id="trid{{ $loop->iteration }}">
            <td class="counter">
              <input type="hidden" id="item_id[]" name="item_id[]" value="{{ $item->id }}">
              <input type="hidden" id="created_by[]" name="created_by[]" value="{{ auth()->user()->id }}">
              {{ $loop->iteration }}
            </td>
            <td><textarea name="description[]" id="description[]" cols="30" class="form-control" {{ $record->user_id != auth()->user()->id ? 'readonly' : '' }}>{{ $item->description }}</textarea></td>
            <td>
              @if (!empty($item->filename_original))
              <a href="{!! asset($item->file_path) !!}" target="_blank"><img src="{!! asset($item->file_path) !!}" alt=" {{ $item->filename_original }}" style="width:100px;height:100px;"></a>
              @endif
              <input type="file" name="file[]" id="file[]" class="btn btn-default btn-block btn-sm" accept="image/*" {{ $record->user_id != auth()->user()->id ? 'disabled' : '' }}>
            </td>
            <td>
              <select name="status_item[]" id="status_item[]" class="form-control" required {{ $record->user_id != auth()->user()->id ? 'readonly' : '' }}>
                <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Suspend</option>
              </select>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <hr>
  <button type="submit" class="save btn btn-primary" data-toggle="tooltip" title='Save'>Save</button>
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