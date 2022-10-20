@extends('layouts.main')

@section('content')
<div class="card col-lg-6">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form method="POST" action="/hrd/superior/{{ $record->id }}">
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
        <input type="hidden" id="updated_at" name="updated_at" value="{{ now() }}">
        <div class="message" style="display: none;"></div>
        <div class="card-body">
          <div class="form-group col-lg-12">
            <label>Superior</label>
            <select name="superior_user_id" id="superior_user_id" class="form-control" required>
              <option value="">- Select -</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ $record->superior_user_id == $user->id ? 'selected' : '' }}>{{ $user->fullname }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-lg-12">
            <label>User</label>
            <select name="user_id" id="user_id" class="form-control" required>
              <option value="">- Select -</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ $record->user_id == $user->id ? 'selected' : '' }}>{{ $user->fullname }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <hr>
        <button type=" submit" class="save btn btn-primary">Save</button>
        <a href="/hrd/superior" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection