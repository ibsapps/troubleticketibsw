@extends('layouts.main')

@section('content')
<div class="card col-lg-6">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form method="POST" action="/hrd/division/{{ $record->id }}">
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
        <div class="card-body">
          <div class="form-group col-lg-12">
            <label>Division Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $record->name }}">
          </div>
          <div class="form-group col-lg-12">
            <label>Division Description</label>
            <textarea name="description" id="description" rows="5" class="form-control">{{ $record->description }}</textarea>
          </div>

          <div class="form-group col-lg-4">
            <label>Status</label>
            <select name="status" id="status" class="form-control">
              <option value="1" {{ $record->status == 1 ? 'selected' : '' }}>Active</option>
              <option value="0" {{ $record->status == 0 ? 'selected' : '' }}>Suspend</option>
            </select>
          </div>
        </div>
        <hr>
        <button type=" submit" class="save btn btn-primary">Save</button>
        <a href="/hrd/division" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection