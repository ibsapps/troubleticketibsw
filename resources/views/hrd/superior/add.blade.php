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
      <form method="POST" action="/hrd/superior">
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
            <label>Superior</label>
            <select name="superior_user_id" id="superior_user_id" class="form-control" required>
              <option value="">- Select -</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->fullname }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-lg-12">
            <label>User</label>
            <select name="user_id" id="user_id" class="form-control" required>
              <option value="">- Select -</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->fullname }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/hrd/superior" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>

@endsection