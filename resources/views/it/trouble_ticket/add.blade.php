@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>


  <div class="form-horizontal">
    <div class="card-body">
      {{-- menampilkan error validasi --}}
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
      <form method="POST" action="/it/trouble_ticket" enctype="multipart/form-data">
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
          <label class="col-lg-1 col-form-label">Date</label>
          <div class="col-lg-2">
            <input type="date" id="request_date" name="request_date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Category</label>
          <div class="col-lg-2">
            <select name="ibs_trouble_ticket_category_id" id="ibs_trouble_ticket_category_id" class="form-control">
              <option value="">- Selected -</option>
              <option value="1">Network</option>
              <option value="2">Support / Hardware</option>
              <option value="3">Application / System</option>
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Priority</label>
          <div class="col-lg-2">
            <select name="priority" id="priority" class="form-control">
              <option value="">- Selected -</option>
              <option value="low">Low</option>
              <option value="normal">Normal</option>
              <option value="high">High</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Request</label>
          <div class="col-lg-5">
            <input type="text" id="request" name="request" class="form-control" value="{{ old('request') }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Description</label>
          <div class="col-lg-5">
            <textarea id="description" name="description" class="form-control" rows="5" value="{{ old('description') }}" required="true"></textarea>
          </div>
          <label class="col-lg-1 col-form-label">Attachment</label>
          <div class="col-lg-2">
            <input type="file" id="file" name="file" class="form-control" value="{{ old('file') }}" accept="image/*">
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/it/trouble_ticket" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>

@endsection
@include('layouts.jsscript')