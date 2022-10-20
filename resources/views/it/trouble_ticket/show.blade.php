@extends('layouts.main')

@section('content')

<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form>
        <div class="message" style="display: none;"></div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">User</label>
          <div class="col-lg-2">
            <input type="text" id="user_name" name="user_name" class="form-control" value="{{ $record->user->ibs_employee->name }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Department</label>
          <div class="col-lg-2">
            <input type="text" id="department_name" name="department_name" class="form-control" value="{{ $record->user->ibs_employee->ibs_department->name }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Date</label>
          <div class="col-lg-2">
            <input type="date" id="ticket_date" name="ticket_date" class="form-control" value="{{ $record->request_date == null ? '' : $record->request_date->format('Y-m-d') }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Due Date</label>
          <div class="col-lg-2">
            <input type="date" id="due_date" name="due_date" class="form-control" value="{{ $record->due_date == null ? '' : $record->due_date->format('Y-m-d') }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Category</label>
          <div class="col-lg-2">
            <input type="text" id="category_name" name="category_name" class="form-control" value="{{ $record->ibs_trouble_ticket_category->name }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Priority</label>
          <div class="col-lg-2">
            <input type="text" name="priority" id="priority" class="form-control" value="{{ $record->priority }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Status</label>
          <div class="col-lg-2">
            <input type="text" name="status" id="status" class="form-control" value="{{ $record->status }}" disabled>
          </div>
          @if ($record->actioned_by_id != null)
            <label class="col-lg-1 col-form-label">PIC</label>
            <div class="col-lg-2">
              <input type="pic" name="pic" class="form-control" value="{{ $record->actioned_by->fullname }}" disabled>
            </div>
          @endif
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Trouble</label>
          <div class="col-lg-5">
            <input type="text" id="request" name="request" class="form-control" value="{{ $record->request }}" disabled>
          </div>
          @if (auth()->user()->ibs_employee->ibs_department_id == 2)
            @if ($record->trouble_repair != null)
              <label class="col-lg-1 col-form-label">Repaired</label>
              <div class="col-lg-2">
                <input type="text" name="trouble_repair" id="trouble_repair" class="form-control" value="{{ $record->trouble_repair }}" disabled>
              </div>
              @if ($record->trouble_repair == 'external')
                <div class="col-lg-3">
                  <input type="text" name="vendor_name" id="vendor_name" class="form-control" value="{{ $record->ibs_vendor->name }}" disabled>
                </div>
              @endif
            @endif
          @endif
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Description</label>
          <div class="col-lg-5">
            <textarea id="description" name="description" class="form-control" disabled="true" rows="5">{{ $record->description }}</textarea>
          </div>
          <label class="col-lg-1 col-form-label">Attachment</label>
          <div class="col-lg-2">
            @if (!empty($record->filename_original))
              <a href="{!! asset($record->file_path) !!}" target="_blank"><img src="{!! asset($record->file_path) !!}" alt=" {{ $record->filename_original }}" style="width:100px;height:100px;"></a>
            @endif
          </div>
        </div>
        <hr>
        @if ($permission->modify == 1)
        @include('it.trouble_ticket.validation')
        @endif
      </form>
    </div>
  </div>
</div>

@endsection
@include('layouts.jsscript')