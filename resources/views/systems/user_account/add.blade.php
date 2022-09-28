@extends('layouts.main')

@section('content')
<div class="card col-lg-6">
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
      <form method="POST" action="/sys/user_account">
        @csrf
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('error') }}
        </div>
        @endif
        <input type="hidden" id="created_by" name="created_by" value="{{ auth()->user()->id }}">
        <div class="message" style="display: none;"></div>
        <div class="card-body">
          <div class="form-group col-lg-12">
            <label>Employee</label>
            <select name="ibs_employee_id" id="ibs_employee_id" class="form-control select_employee" style="width: 100%;">
              <option value="">- Select -</option>
              @foreach ($employees as $key => $value)
              <option value="<?= $value->id ?>" emp_nik="<?= $value->nik ?>" emp_email="<?= $value->email ?>" emp_name="<?= $value->name ?>"><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-lg-12">
            <label>Username</label>
            <input type="hidden" name="fullname" id="fullname" class="form-control">
            <input type="text" name="username" id="username" class="form-control" readonly>
          </div>
          <div class="form-group col-lg-12">
            <label>Email</label>
            <input type="email" name="email" id="email" class="form-control" readonly>
          </div>
          <div class="form-group col-lg-12">
            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" maxlength="64">
          </div>
        </div>
        <hr>
        <button type="submit" class="save btn btn-primary">Save</button>
        <a href="/sys/user_account" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>

@endsection