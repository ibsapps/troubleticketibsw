@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="card-body">
    <div class="row mb-2">
      @if ($permission->create == 1)
      <div class="col-lg-6">
        <a type="button" href="/hrd/employee/create" class="btn btn-primary">ADD</a>
      </div>
      <hr>
      @endif
      <div class="col-lg-6">
        <div class=" col-lg-3 float-right">
          @if ($permission->import == 1)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-import">
              IMPORT
            </button>
            <a type="button" class="btn btn-primary modal">IMPORT</a>
          @endif
        </div>
        <div class="col-lg-3 float-right">
          <select id="list_status" name="list_status" class="form-control" tbl="employee">
            <option value="1" {{ isset($list_status) ? ($list_status == 1 ? 'selected' : '') : 'selected'  }}>Active</option>
            <option value="2" {{ isset($list_status) ? ($list_status == 2 ? 'selected' : '') : ''  }}>Resign</option>
            <option value="3" {{ isset($list_status) ? ($list_status == 3 ? 'selected' : '') : ''  }}>End of Contract</option>
          </select>
        </div>
      </div>
    </div>
    <hr>
    <div class="table-responsive">
      <div class="row">
        <div class="col-lg-12">
          <div class="table-responsive">
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
  </div>
</div>

<div class="modal fade" id="modal-import" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><b>Form Import Employee</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/hrd/employee/upload" method="post" enctype="multipart/form-data">
          @csrf
          <input type="file" name="file" id="file" class="form-control" placeholder="Recipient's username"
              aria-label="Recipient's username" aria-describedby="button-addon2" accept="application/vnd.ms-excel">
          <button class="btn btn-primary mt-3" type="submit" id="button-addon2">Import</button>
        </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div> -->
    </div>
  </div>
</div>
@endsection