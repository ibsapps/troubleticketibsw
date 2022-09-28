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
            <input type="date" id="ticket_date" name="ticket_date" class="form-control" value="{{ date('Y-m-d') }}" disabled>
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
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Request</label>
          <div class="col-lg-5">
            <input type="text" id="request" name="request" class="form-control" value="{{ $record->request }}" disabled>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-12" style="overflow: auto; height: 250px;">
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
                    {{ $loop->iteration }}
                  </td>
                  <td><textarea name="description[]" id="description[]" cols="30" class="form-control" disabled>{{ $item->description }}</textarea></td>
                  <td>
                    @if (!empty($item->filename_original))
                    <a href="{!! asset($item->file_path) !!}" target="_blank"><img src="{!! asset($item->file_path) !!}" alt=" {{ $item->filename_original }}" style="width:100px;height:100px;"></a>
                    @endif
                  </td>
                  <td>
                    <input type="status_item[]" id="status_item[]" class="form-control" disabled value="{{ $item->status == 1 ? 'Active' : 'Suspend' }}">
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
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