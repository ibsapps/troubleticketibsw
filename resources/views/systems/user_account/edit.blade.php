@extends('layouts.main')

@section('content')
<div class="card col-lg-6">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form method="POST" action="/sys/user_account/{{ $record->id }}">
        @method('PUT')
        @csrf
        <input type="hidden" id="id" name="id" value="{{ $record->id }}">
        <input type="hidden" id="updated_by" name="updated_by" value="{{ auth()->user()->id }}">
        <div class="message" style="display: none;"></div>
        <div class="card-body">
          <div class="form-group col-lg-12">
            <label>Employee</label>
            <input type="text" name="employee_name" id="employee_name" class="form-control" value="{{ $record->fullname }}" readonly>
          </div>
          <div class="form-group col-lg-12">
            <label>Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ $record->username }}" readonly>
          </div>
          <div class="form-group col-lg-12">
            <label>Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $record->email }}">
          </div>
          <div class="form-group col-lg-12">
            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" maxlength="64">
          </div>
        </div>
        <hr>
        <button type=" submit" class="save btn btn-primary">Save</button>
        <a href="/sys/user_account" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection