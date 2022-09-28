@extends('layouts.main')

@section('content')

<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form method="POST" action="/it/trouble_ticket/{{ $record->id }}" enctype="multipart/form-data">
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
            <input type="date" id="ticket_date" name="ticket_date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Category</label>
          <div class="col-lg-2">
            <input type="text" id="category_name" name="category_name" class="form-control" value="{{ $record->ibs_trouble_ticket_category->name }}" readonly>
          </div>
          <label class="col-lg-1 col-form-label">Priority</label>
          <div class="col-lg-2">
            @if ($record->status == 'open')
            <select name="priority" id="priority" class="form-control">
              <option value="">- Selected -</option>
              <option value="low" {{ $record->priority == 'low' ? 'selected' : '' }}>Low</option>
              <option value="normal" {{ $record->priority == 'normal' ? 'selected' : '' }}>Normal</option>
              <option value="high" {{ $record->priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
            @else
            <input type="text" name="priority" id="priority" class="form-control" value="{{ $record->priority }}" readonly>
            @endif
          </div>
          <label class="col-lg-1 col-form-label">Status</label>
          <div class="col-lg-2">
            @if (auth()->user()->ibs_employee->ibs_department_id == 2)
            <select name="status" id="status" class="form-control">
              <option value="open" {{ $record->status == 'open' ? 'selected' : '' }}>Open</option>
              <option value="on progress" {{ $record->status == 'on progress' ? 'selected' : '' }}>On Progress</option>
              <option value="close" {{ $record->status == 'close' ? 'selected' : '' }}>Close</option>
              <option value="reject" {{ $record->status == 'reject' ? 'selected' : '' }}>Reject</option>
            </select>
            @else
            <input type="text" name="status" id="status" class="form-control" value="{{  $record->status }}" readonly>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Request</label>
          <div class="col-lg-5">
            <input type="text" id="request" name="request" class="form-control" value="{{ $record->request }}" {{ $record->user_id != auth()->user()->id ? 'readonly' : ($record->status == 'open' ? '' : 'readonly') }}>
          </div>
        </div>
        <hr>
        @if ($record->user_id == auth()->user()->id)
        @if ($record->status == 'open')
        <div class="col-lg-6">
          <button type="button" id="add_item" name="add_item" tbl="trouble_ticket" class="btn btn-primary">Add</button>
        </div>
        @endif
        @endif
        <br>
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
                    <input type="hidden" id="item_id[]" name="item_id[]" value="{{ $item->id }}">
                    <input type="hidden" id="created_by[]" name="created_by[]" value="{{ auth()->user()->id }}">
                    {{ $loop->iteration }}
                  </td>
                  @if ($record->status == 'open')
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
                  @else
                  <td><textarea name="description[]" id="description[]" cols="30" class="form-control" readonly>{{ $item->description }}</textarea></td>
                  <td>
                    @if (!empty($item->filename_original))
                    <a href="{!! asset($item->file_path) !!}" target="_blank"><img src="{!! asset($item->file_path) !!}" alt=" {{ $item->filename_original }}" style="width:100px;height:100px;"></a>
                    @endif
                  </td>
                  <td>
                    <input type="hidden" name="status_item[]" id="status_item[]" class="form-control" value="{{ $item->status }}" readonly>
                    <input type="text" class="form-control" value="{{ $item->status == 1 ? 'Active' : 'Suspend' }}" readonly>
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <hr>
        <button type="submit" class="save btn btn-primary" data-toggle="tooltip" title='Save'>Save</button>
        <a href="/it/trouble_ticket" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>

@endsection
@include('layouts.jsscript')