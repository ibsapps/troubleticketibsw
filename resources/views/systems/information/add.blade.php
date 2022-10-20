@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <!-- {{-- menampilkan error validasi --}} -->
      @if (count($errors) > 0)
      <div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form method="POST" action="/sys/information" enctype="multipart/form-data">
        @csrf
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('error') }}
        </div>
        @endif
        <input type="hidden" id="created_by" name="created_by" value="{{ auth()->user()->id }}">
        <div class="message" style="display: none;"></div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">User</label>
          <div class="col-lg-2">
            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ auth()->user()->id }}">
            <input type="text" id="user_name" name="user_name" class="form-control" value="{{ auth()->user()->ibs_employee->name }}" readonly>
          </div>
          <label class="col-lg-1 col-form-label">Department</label>
          <div class="col-lg-2">
            <input type="hidden" id="ibs_department_id" name="ibs_department_id" class="form-control" value="{{ auth()->user()->ibs_employee->ibs_department_id }}">
            <input type="text" id="department_name" name="department_name" class="form-control" value="{{ auth()->user()->ibs_employee->ibs_department->name }}" readonly>
          </div>
          <label class="col-lg-1 col-form-label">Live Until</label>
          <div class="col-lg-2">
            <input type="date" id="live_until" name="live_until" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Title</label>
          <div class="col-lg-5">
            <input type="text" id="title" name="title" class="form-control" required>
          </div>
          <label class="col-lg-1 col-form-label">Image Upload</label>
          <div class="col-lg-2">
            <input type="file" name="file" id="file" class="btn btn-default btn-block btn-sm" accept="image/*">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Description</label>
          <div class="col-lg-8">
            <textarea name="description" id="description" rows="10" class="form-control" required></textarea>
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/sys/information" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>

@endsection
@include('layouts.jsscript')