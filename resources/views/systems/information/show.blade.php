@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form>
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
        <div class="row mb-2">
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">User</label>
              <div class="col-lg-4">
                <input type="text" id="user_name" name="user_name" class="form-control" value="{{ $record->user->fullname }}" disabled>
              </div>
              <label class="col-lg-2 col-form-label">Department</label>
              <div class="col-lg-3">
                <input type="text" id="department_name" name="department_name" class="form-control" value="{{ $record->ibs_department->name }}" disabled>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Title</label>
              <div class="col-lg-9">
                <input type="text" id="title" name="title" class="form-control" value="{{ $record->title }}" disabled>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Description</label>
              <div class="col-lg-9">
                <textarea name="description" id="description" rows="10" class="form-control" disabled>{{ $record->description }}</textarea>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Live Until</label>
              <div class="col-lg-3">
                <input type="date" id="live_until" name="live_until" class="form-control" value="{{ $record->live_until }}" disabled>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Image Upload</label>
              <div class="col-lg-4">
                <a href="{!! asset($record->file_path) !!}" target="_blank"><img src="{!! asset($record->file_path) !!}" alt=" {{ $record->filename_original }}" style="width:100px;height:100px;"></a>
              </div>
            </div>
          </div>

        </div>
        <hr>
        @include('systems.information.validation')
      </form>
    </div>
  </div>
</div>
@endsection

@include('layouts.jsscript')