@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-lg-12">
        @if (session('success'))
        <div class="alert alert-success" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('success') }}
        </div>
        @endif
      </div>
      <div class="col-lg-6">
        @if ($permission->create == 1)
        <a type="button" href="/hrd/employee/create" class="btn btn-primary">ADD</a>
        @endif
      </div>
      <div class="col-lg-6">
        <div class=" col-lg-2 float-right">
        </div>
      </div>
    </div>
    <!-- <hr> -->
    <div class="row">
      <div class="col-lg-12">
        <table id="dtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>Action</th>
              <th>NIK</th>
              <th>NAME</th>
              <th>DIVISION</th>
              <th>DEPARTMENT</th>
              <th>POSITION</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($records as $record)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><a href="/hrd/employee/{{ $record->id}}" class="btn btn-info">Show</a></td>
              <td>{{ $record->nik }}</td>
              <td>{{ $record->name }}</td>
              <td>{{ $record->ibs_division->name }}</td>
              <td>{{ $record->ibs_department->name }}</td>
              <td>{{ $record->ibs_position->name }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection